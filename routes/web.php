<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'login');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalUsers' => 25,
            'activeOperators' => 8,
            'activeMekaniks' => 5,
            'pendingTasks' => 12
        ]);
    })->name('dashboard');

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{id}/restore', [App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');
    Route::get('/operators', function() { return view('admin.operators.index'); })->name('operators.index');
    Route::get('/mekaniks', function() { return view('admin.mekaniks.index'); })->name('mekaniks.index');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', function() { return view('admin.settings.index'); })->name('settings.index');
});

// Operator Routes
Route::prefix('operator')->name('operator.')->middleware(['auth', 'operator'])->group(function () {
    Route::get('/dashboard', function () {
        return view('operator.dashboard', [
            'todayTasks' => 8,
            'completedTasks' => 5,
            'pendingTasks' => 3,
            'workingHours' => '7h 30m'
        ]);
    })->name('dashboard');
    
    Route::get('/tasks', function() { return view('operator.tasks.index'); })->name('tasks.index');
    Route::get('/schedules', function() { return view('operator.schedules.index'); })->name('schedules.index');
    Route::get('/reports', function() { return view('operator.reports.index'); })->name('reports.index');
    Route::get('/maintenance', function() { return view('operator.maintenance.index'); })->name('maintenance.index');
});

// Mekanik Routes
Route::prefix('mekanik')->name('mekanik.')->middleware(['auth', 'mekanik'])->group(function () {
    Route::get('/dashboard', function () {
        return view('mekanik.dashboard', [
            'activeWorkOrders' => 6,
            'completedRepairs' => 12,
            'scheduledMaintenance' => 4,
            'urgentRepairs' => 2
        ]);
    })->name('dashboard');
    
    Route::get('/work-orders', function() { return view('mekanik.work-orders.index'); })->name('work-orders.index');
    Route::get('/maintenance', function() { return view('mekanik.maintenance.index'); })->name('maintenance.index');
    Route::get('/repairs', function() { return view('mekanik.repairs.index'); })->name('repairs.index');
    Route::get('/inventory', function() { return view('mekanik.inventory.index'); })->name('inventory.index');
    Route::get('/reports', function() { return view('mekanik.reports.index'); })->name('reports.index');
});

// Common routes
Route::get('/profile', function() { return view('profile.edit'); })->name('profile');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/password/request', function() { return view('auth.forgot-password'); })->name('password.request');