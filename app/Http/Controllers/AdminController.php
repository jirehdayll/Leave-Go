<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // List all employees
    public function employees()
    {
        $employees = User::orderBy('name')->get();
        return view('admin.employees', compact('employees'));
    }

    // Deactivate employee
    public function deactivateEmployee($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = false;
        $user->save();
        return back()->with('success', 'Account deactivated.');
    }

    // Edit employee
    public function editEmployee($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_employee', compact('user'));
    }

    // Update employee
    public function updateEmployee(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'required|boolean',
        ]);
        $user->update($validated);
        return redirect()->route('admin.employees')->with('success', 'Account updated.');
    }

    // List all approved forms
    public function approved()
    {
        $approved = LeaveRequest::where('status', 'approved')->orderByDesc('created_at')->get();
        return view('admin.approved', compact('approved'));
    }

    public function requestPdf($id)
    {
        $req = LeaveRequest::findOrFail($id);
        $pdf = Pdf::loadView('admin.request_pdf', ['req' => $req])->setPaper('a4', 'portrait');
        $filename = ($req->type === 'travel' ? 'Travel_Order_' : 'Leave_Application_') . $req->name . '.pdf';
        return $pdf->download($filename);
    }

    public function monthlyPdf(Request $request)
    {
        $month = (int) $request->query('month', date('n'));
        $year  = (int) $request->query('year', date('Y'));
        $type  = $request->query('type', '');

        $query = LeaveRequest::where('status', 'approved')
            ->whereMonth('date_filling', $month)
            ->whereYear('date_filling', $year);

        if ($type !== '') {
            if ($type === 'leave') {
                $query->whereIn('type', ['leave', 'sick']);
            } else {
                $query->where('type', $type);
            }
        }

        $approved = $query->orderBy('name')->get();

        $pdf = Pdf::loadView('admin.monthly_pdf_clean', [
            'approved' => $approved,
            'month' => $month,
            'year' => $year,
            'type' => $type,
        ])->setPaper('a4', 'landscape');

        $filename = 'Monthly_Summary_' . $month . '_' . $year . '.pdf';
        return $pdf->download($filename);
    }
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function dashboard(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        $query = match($tab) {
            'important' => LeaveRequest::where('is_starred', true)->where('status', 'pending'),
            'trash'     => LeaveRequest::where('status', 'trash'),
            default     => LeaveRequest::where('status', 'pending'),
        };

        $requests = $query->latest()->limit(50)->get();

        $allStats = [
            'travel_pending' => LeaveRequest::where('status', 'pending')->where('type', 'travel')->count(),
            'leave_pending'  => LeaveRequest::where('status', 'pending')->whereIn('type', ['leave', 'sick'])->count(),
            'approved_leave' => LeaveRequest::where('status', 'approved')->whereIn('type', ['leave', 'sick'])->count(),
            'approved_travel'=> LeaveRequest::where('status', 'approved')->where('type', 'travel')->count(),
            'total'          => LeaveRequest::count(),
        ];

        $pendingCount = $allStats['travel_pending'] + $allStats['leave_pending'];

        return view('admin.dashboard', compact('requests', 'tab', 'allStats', 'pendingCount'));
    }

    public function star($id)
    {
        $req = LeaveRequest::findOrFail($id);
        $req->is_starred = !$req->is_starred;
        $req->save();
        return response()->json(['is_starred' => $req->is_starred]);
    }

    public function trash($id)
    {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'trash';
        $req->save();
        return response()->json(['ok' => true]);
    }

    public function restore($id)
    {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'pending';
        $req->save();
        return response()->json(['ok' => true]);
    }

    public function approve($id)
    {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'approved';
        $req->save();
        return response()->json(['ok' => true]);
    }

    public function reject($id)
    {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->save();
        return response()->json(['ok' => true]);
    }

    public function detail($id)
    {
        $req = LeaveRequest::findOrFail($id);
        return response()->json($req);
    }

    public function poll(Request $request)
    {
        $since = $request->query('since');
        $tab   = $request->query('tab', 'pending');

        $query = match($tab) {
            'important' => LeaveRequest::where('is_starred', true)->where('status', 'pending'),
            'trash'     => LeaveRequest::where('status', 'trash'),
            default     => LeaveRequest::where('status', 'pending'),
        };

        if ($since) {
            $query->where('created_at', '>', $since);
        }

        $newRequests = $query->latest()->get()->map(function($r) {
            return [
                'id'          => $r->id,
                'name'        => $r->name,
                'type'        => $r->type,
                'office'      => $r->office,
                'date_filling'=> $r->date_filling ? $r->date_filling->format('M d, Y') : '—',
                'days'        => $r->details['working_days_applied'] ?? '—',
                'is_starred'  => $r->is_starred,
                'status'      => $r->status,
                'created_at'  => $r->created_at->toISOString(),
            ];
        });

        $stats = [
            'travel_pending' => LeaveRequest::where('status', 'pending')->where('type', 'travel')->count(),
            'leave_pending'  => LeaveRequest::where('status', 'pending')->whereIn('type', ['leave', 'sick'])->count(),
            'approved_leave' => LeaveRequest::where('status', 'approved')->whereIn('type', ['leave', 'sick'])->count(),
            'approved_travel'=> LeaveRequest::where('status', 'approved')->where('type', 'travel')->count(),
        ];

        return response()->json(['requests' => $newRequests, 'stats' => $stats, 'server_time' => now()->toISOString()]);
    }

    public function monthly(Request $request)
    {
        $month = (int) $request->query('month', date('n'));
        $year  = (int) $request->query('year', date('Y'));
        $type  = $request->query('type', '');

        $query = LeaveRequest::where('status', 'approved')
            ->whereMonth('date_filling', $month)
            ->whereYear('date_filling', $year);

        if ($type !== '') {
            if ($type === 'leave') {
                $query->whereIn('type', ['leave', 'sick']);
            } else {
                $query->where('type', $type);
            }
        }

        $approved = $query->orderBy('name')->get();

        return view('admin.monthly', compact('approved', 'month', 'year', 'type'));
    }

    public function createAccount()
    {
        return view('admin.create_account');
    }

    public function storeAccount(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_admin' => (bool) $validated['is_admin'],
        ]);

        // Send custom verification email
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60*24),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        \Mail::send('emails.verify_greeting', [
            'user' => $user,
            'verificationUrl' => $verificationUrl,
        ], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Welcome to LeaveGo! Please verify your email');
        });

        return back()->with('success', 'Account for ' . $validated['name'] . ' has been created successfully! Verification email sent.');
    }
}
