<?php

use App\Http\Controllers\Admin\ApplicationTypeController;
use App\Http\Controllers\Admin\ApplicationTypeStageController;
use App\Http\Controllers\Admin\ApplicationTypeTaskController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Izlanuvchi: ariza topshirish
    Route::get('/apply', [ApplicationController::class, 'create'])->name('apply.create')->middleware('role:izlanuvchi');
    Route::post('/apply/{applicationType}', [ApplicationController::class, 'store'])->name('apply.store')->middleware('role:izlanuvchi');

    // Loyihalar (rolga qarab avtorizatsiya kontroller/policy ichida)
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // Hujjatni yuklab olish (yuklash, tasdiqlash, rad etish — loyiha sahifasidagi Livewire komponenti orqali)
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Admin panel
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('application-types', ApplicationTypeController::class)->except(['show'])->parameters([
            'application-types' => 'applicationType',
        ]);
        Route::get('application-types/{applicationType}', [ApplicationTypeController::class, 'show'])->name('application-types.show');

        Route::post('application-types/{applicationType}/stages', [ApplicationTypeStageController::class, 'store'])->name('application-types.stages.store');
        Route::put('application-types/{applicationType}/stages/{stage}', [ApplicationTypeStageController::class, 'update'])->name('application-types.stages.update');
        Route::delete('application-types/{applicationType}/stages/{stage}', [ApplicationTypeStageController::class, 'destroy'])->name('application-types.stages.destroy');

        Route::post('stages/{stage}/tasks', [ApplicationTypeTaskController::class, 'store'])->name('stages.tasks.store');
        Route::put('tasks/{task}', [ApplicationTypeTaskController::class, 'update'])->name('tasks.update');
        Route::delete('tasks/{task}', [ApplicationTypeTaskController::class, 'destroy'])->name('tasks.destroy');

        Route::resource('users', UserController::class)->except(['show']);

        Route::get('projects', [AdminProjectController::class, 'index'])->name('projects.index');
    });
});

require __DIR__.'/auth.php';
