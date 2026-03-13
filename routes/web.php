<?php

use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;

// ─── Auth ───────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('auth.login_ios');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        // Admin goes directly to dashboard
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('selection');
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
})->name('login.post');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ─── User Pages ──────────────────────────────────────────────────────────
Route::get('/selection', function () {
    return view('selection');
})->name('selection');

Route::get('/forms/leave', function () {
    return view('forms.leave');
})->name('forms.leave');

Route::get('/forms/travel', function () {
    return view('forms.travel');
})->name('forms.travel');

// Keep old sick route as alias
Route::get('/forms/sick', function () {
    return view('forms.leave');
})->name('forms.sick');

Route::post('/forms/submit', [LeaveRequestController::class, 'store'])->name('forms.submit');

Route::get('/forms/success', function () {
    return view('forms.success');
})->name('forms.success');

// ─── Admin Dashboard ─────────────────────────────────────────────────────
Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/admin/dashboard', function (Request $request) {
        $tab = $request->query('tab', 'pending');

        $query = match($tab) {
            'important' => LeaveRequest::where('is_starred', true)->where('status', 'pending'),
            'trash'     => LeaveRequest::where('status', 'trash'),
            default     => LeaveRequest::where('status', 'pending'),
        };

        $requests = $query->latest()->get();

        $allStats = [
            'travel_pending' => LeaveRequest::where('status', 'pending')->where('type', 'travel')->count(),
            'leave_pending'  => LeaveRequest::where('status', 'pending')->where(function($q) { $q->where('type', 'leave')->orWhere('type', 'sick'); })->count(),
            'approved_leave' => LeaveRequest::where('status', 'approved')->where(function($q) { $q->where('type', 'leave')->orWhere('type', 'sick'); })->count(),
            'approved_travel'=> LeaveRequest::where('status', 'approved')->where('type', 'travel')->count(),
            'total'          => LeaveRequest::count(),
        ];
        $pendingCount = $allStats['travel_pending'] + $allStats['leave_pending'];

        return view('admin.dashboard', compact('requests', 'tab', 'allStats', 'pendingCount'));
    })->name('admin.dashboard');

    // Star / Unstar
    Route::post('/admin/requests/{id}/star', function ($id) {
        $req = LeaveRequest::findOrFail($id);
        $req->is_starred = !$req->is_starred;
        $req->save();
        return response()->json(['is_starred' => $req->is_starred]);
    });

    // Trash
    Route::post('/admin/requests/{id}/trash', function ($id) {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'trash';
        $req->save();
        return response()->json(['ok' => true]);
    });

    // Restore
    Route::post('/admin/requests/{id}/restore', function ($id) {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'pending';
        $req->save();
        return response()->json(['ok' => true]);
    });

    // Approve
    Route::post('/admin/requests/{id}/approve', function ($id) {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'approved';
        $req->save();
        return response()->json(['ok' => true]);
    });

    // Monthly Summary
    Route::get('/admin/monthly', function (Request $request) {
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
    })->name('admin.monthly');

    // Create Account — show form
    Route::get('/admin/create-account', function () {
        return view('admin.create_account');
    })->name('admin.create-account');

    // Create Account — process
    Route::post('/admin/create-account', function (Request $request) {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);

        \App\Models\User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_admin' => (bool) $validated['is_admin'],
        ]);

        return back()->with('success', 'Account for ' . $validated['name'] . ' has been created successfully!');
    })->name('admin.store-account');

    // ── Detail view (read-only JSON for modal) ────────────────────────────
    Route::get('/admin/requests/{id}', function ($id) {
        $req = LeaveRequest::findOrFail($id);
        return response()->json($req);
    })->name('admin.request.detail');

    // ── Polling: return requests newer than given timestamp ───────────────
    Route::get('/admin/poll', function (Request $request) {
        $since = $request->query('since'); // ISO timestamp
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
            'leave_pending'  => LeaveRequest::where('status', 'pending')->where(function($q) { $q->where('type', 'leave')->orWhere('type', 'sick'); })->count(),
            'approved_leave' => LeaveRequest::where('status', 'approved')->where(function($q) { $q->where('type', 'leave')->orWhere('type', 'sick'); })->count(),
            'approved_travel'=> LeaveRequest::where('status', 'approved')->where('type', 'travel')->count(),
        ];

        return response()->json(['requests' => $newRequests, 'stats' => $stats, 'server_time' => now()->toISOString()]);
    })->name('admin.poll');

    // ── Reject ────────────────────────────────────────────────────────────
    Route::post('/admin/requests/{id}/reject', function ($id) {
        $req = LeaveRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->save();
        return response()->json(['ok' => true]);
    });
});


// ─── Dashboard ─────────────────────────────────────────────────────────────
Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('selection');
})->middleware('auth')->name('dashboard');

// ─── Employee Management ───────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class)->names([
        'index' => 'employees.index',
        'create' => 'employees.create',
        'store' => 'employees.store',
        'show' => 'employees.show',
        'edit' => 'employees.edit',
        'update' => 'employees.update',
        'destroy' => 'employees.destroy',
    ]);
    
    Route::post('/employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])
        ->name('employees.toggle-status');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
