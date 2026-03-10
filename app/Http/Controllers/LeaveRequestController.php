<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'office' => 'required|string',
            'name' => 'required|string',
            'date_filling' => 'required|date',
            'position' => 'required|string',
            'salary' => 'required|string',
        ]);

        LeaveRequest::create($validated);

        return redirect()->route('forms.success');
    }

    public function index()
    {
        $requests = LeaveRequest::latest()->get();
        // This could be used for the admin dashboard later
        return view('admin.dashboard', compact('requests'));
    }
}
