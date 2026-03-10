<?php

use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Simple redirect for now to demonstration
    return redirect()->route('selection');
});

Route::get('/selection', function () {
    return view('selection');
})->name('selection');

Route::get('/forms/travel', function () {
    return view('forms.travel');
})->name('forms.travel');

Route::get('/forms/sick', function () {
    return view('forms.sick');
})->name('forms.sick');

Route::post('/forms/submit', [LeaveRequestController::class, 'store'])->name('forms.submit');

Route::get('/forms/success', function () {
    return view('forms.success');
})->name('forms.success');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
