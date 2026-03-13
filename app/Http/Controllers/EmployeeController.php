<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = User::where('is_admin', false)->latest()->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Employee name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'An employee with this email already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = false;

        User::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee account created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(User $employee)
    {
        if ($employee->is_admin && !auth()->user()->is_admin) {
            abort(403);
        }
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $employee)
    {
        if ($employee->is_admin && !auth()->user()->is_admin) {
            abort(403);
        }
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, User $employee)
    {
        if ($employee->is_admin && !auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee->id),
            ],
            'position' => 'nullable|string|max:255',
            'salary' => 'nullable|string|max:255',
            'office' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Employee name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'An employee with this email already exists.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee information updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(User $employee)
    {
        if ($employee->is_admin) {
            abort(403, 'Cannot delete admin accounts.');
        }

        if ($employee->id === auth()->id()) {
            abort(403, 'You cannot delete your own account.');
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee account deactivated successfully.');
    }

    /**
     * Toggle employee active status (soft delete alternative).
     */
    public function toggleStatus(User $employee)
    {
        if ($employee->is_admin) {
            abort(403, 'Cannot deactivate admin accounts.');
        }

        if ($employee->id === auth()->id()) {
            abort(403, 'You cannot deactivate your own account.');
        }

        $employee->update(['is_active' => !$employee->is_active]);

        $status = $employee->is_active ? 'activated' : 'deactivated';
        return redirect()->route('employees.index')
            ->with('success', "Employee account {$status} successfully.");
    }
}
