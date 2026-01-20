<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'login');
});

// Manager Routes
Route::prefix('manager')->name('manager.')->middleware(['auth', 'manager'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('tasks', App\Http\Controllers\Manager\TaskController::class);
    Route::get('/team', [App\Http\Controllers\Manager\TeamController::class, 'index'])->name('team.index');
    Route::resource('reports', App\Http\Controllers\Manager\ReportController::class)->only(['index', 'show']);

    // Equipment & Maintenance
    Route::resource('equipment-types', App\Http\Controllers\Manager\EquipmentTypeController::class);
    Route::resource('equipment', App\Http\Controllers\Manager\EquipmentController::class);
    Route::resource('maintenance', App\Http\Controllers\Manager\MaintenanceController::class);
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::patch('users/{id}/restore', [App\Http\Controllers\Admin\UserController::class, 'restore'])->name('users.restore');

    Route::resource('operators', App\Http\Controllers\Admin\OperatorController::class);
    Route::patch('operators/{id}/restore', [App\Http\Controllers\Admin\OperatorController::class, 'restore'])->name('operators.restore');

    Route::resource('mekaniks', App\Http\Controllers\Admin\MekanikController::class);
    Route::patch('mekaniks/{id}/restore', [App\Http\Controllers\Admin\MekanikController::class, 'restore'])->name('mekaniks.restore');

    // Master Data & Operations


    // Reports
    Route::resource('reports', App\Http\Controllers\Admin\ReportController::class)->only(['index', 'show', 'update', 'destroy']);

    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/toggle-maintenance', [App\Http\Controllers\Admin\SettingController::class, 'toggleMaintenance'])->name('settings.toggle-maintenance');
    Route::post('settings/backup', [App\Http\Controllers\Admin\SettingController::class, 'backup'])->name('settings.backup');
    Route::post('settings/clear-cache', [App\Http\Controllers\Admin\SettingController::class, 'clearCache'])->name('settings.clear-cache');
});

// Operator Routes
Route::prefix('operator')->name('operator.')->middleware(['auth', 'operator'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Operator\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tasks', [App\Http\Controllers\Operator\TaskController::class, 'index'])->name('tasks.index');
    Route::put('/tasks/{id}/status', [App\Http\Controllers\Operator\TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::get('/equipment', [App\Http\Controllers\Operator\EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/schedules', [App\Http\Controllers\Operator\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/reports', function () {
        return view('operator.reports.index'); })->name('reports.index');
    Route::get('/maintenance', [App\Http\Controllers\Operator\MaintenanceController::class, 'index'])->name('maintenance.index');
});

// Mekanik Routes
Route::prefix('mekanik')->name('mekanik.')->middleware(['auth', 'mekanik'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Mekanik\DashboardController::class, 'index'])->name('dashboard');

    // Work Orders / Tasks
    Route::get('/work-orders', [App\Http\Controllers\Mekanik\TaskController::class, 'index'])->name('work-orders.index');
    Route::put('/work-orders/{id}', [App\Http\Controllers\Mekanik\TaskController::class, 'update'])->name('work-orders.update');

    // Schedules
    Route::get('/schedules', [App\Http\Controllers\Mekanik\ScheduleController::class, 'index'])->name('schedules.index');

    // Maintenance
    Route::get('/maintenance', [App\Http\Controllers\Mekanik\MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::put('/maintenance/{id}', [App\Http\Controllers\Mekanik\MaintenanceController::class, 'update'])->name('maintenance.update');

    // Repairs
    Route::get('/repairs', [App\Http\Controllers\Mekanik\TaskController::class, 'index'])->name('repairs.index');

    // Inventory / Equipment
    Route::get('/inventory', [App\Http\Controllers\Mekanik\EquipmentController::class, 'index'])->name('inventory.index');
    Route::put('/inventory/{id}', [App\Http\Controllers\Mekanik\EquipmentController::class, 'update'])->name('inventory.update');

    // Reports
    Route::get('/reports', [App\Http\Controllers\Mekanik\ReportController::class, 'index'])->name('reports.index');
    Route::put('/reports/{id}', [App\Http\Controllers\Mekanik\ReportController::class, 'update'])->name('reports.update');
});

// Common routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/password/request', function() { return view('auth.forgot-password'); })->name('password.request');