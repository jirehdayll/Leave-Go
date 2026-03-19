<?php

use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Str;

// ─── Auth ───────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('auth.login');
})->name('login.page');

// Use Laravel UI auth routes without login/register
Auth::routes(['login' => true, 'register' => false, 'reset' => true]);

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

// ─── Admin Bypass (Direct Access) ────────────────────────────────────────
Route::get('/admin/direct-access', function () {
    try {
        $admin = \App\Models\User::where('is_admin', true)->first();
        if ($admin) {
            Auth::login($admin);
            return redirect()->route('admin.dashboard');
        }
    } catch (\Exception $e) {
        return redirect()->route('login.page')->withErrors(['error' => 'Database error: ' . $e->getMessage()]);
    }
    return redirect()->route('login.page')->withErrors(['error' => 'No admin user found.']);
})->name('admin.direct-access');

Route::get('/admin/test/bypass', function () {
    return redirect()->route('admin.direct-access');
});

// ─── Admin Dashboard ─────────────────────────────────────────────────────
Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/requests/{id}/star', [AdminController::class, 'star']);
    Route::post('/admin/requests/{id}/trash', [AdminController::class, 'trash']);
    Route::post('/admin/requests/{id}/restore', [AdminController::class, 'restore']);
    Route::post('/admin/requests/{id}/approve', [AdminController::class, 'approve']);
    Route::post('/admin/requests/{id}/reject', [AdminController::class, 'reject']);
    Route::get('/admin/requests/{id}', [AdminController::class, 'detail'])->name('admin.request.detail');
    Route::get('/admin/requests/{id}/pdf', [AdminController::class, 'requestPdf'])->name('admin.request.pdf');
    Route::get('/admin/poll', [AdminController::class, 'poll'])->name('admin.poll');
    Route::get('/admin/monthly', [AdminController::class, 'monthly'])->name('admin.monthly');
    Route::get('/admin/monthly/pdf', [AdminController::class, 'monthlyPdf'])->name('admin.monthly.pdf');
    Route::get('/admin/create-account', [AdminController::class, 'createAccount'])->name('admin.create-account');
    Route::post('/admin/create-account', [AdminController::class, 'storeAccount'])->name('admin.store-account');
    Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees');
    Route::post('/admin/employees/{id}/deactivate', [AdminController::class, 'deactivateEmployee'])->name('admin.employees.deactivate');
    Route::get('/admin/employees/{id}/edit', [AdminController::class, 'editEmployee'])->name('admin.employees.edit');
    Route::post('/admin/employees/{id}/edit', [AdminController::class, 'updateEmployee'])->name('admin.employees.update');
    Route::get('/admin/approved', [AdminController::class, 'approved'])->name('admin.approved');
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


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

