<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use App\Models\Workspace;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $workspaces = Workspace::get();

    return view('dashboard', [
        'workspaces' => $workspaces,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'delete')->name('profile.destroy');
    });

    Route::prefix('workspaces')->name('workspaces.')->group(function () {
        Route::controller(WorkspaceController::class)->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
        });
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::controller(TaskController::class)->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
        });
    });
});

require __DIR__.'/auth.php';
