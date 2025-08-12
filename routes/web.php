<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/workspace', function () {
    $workspaces = Workspace::get();

    return view('workspace', [
        'workspaces' => $workspaces,
        'user' => Auth::id(),
    ]);
})->middleware(['auth', 'verified'])->name('workspace');

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'delete')->name('profile.destroy');
    });

    Route::prefix('workspaces')->name('workspaces.')->group(function () {
        Route::controller(WorkspaceController::class)->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{workspace}', 'delete')->name('delete')->middleware('can:delete,workspace');
        });
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::controller(TaskController::class)->group(function () {
            Route::post('/store', 'store')->name('store');
            Route::put('/update/{task}', 'update')->name('update')->middleware('can:update,task');
            Route::delete('/delete/{task}', 'delete')->name('delete')->middleware('can:delete,task');
        });
    });
});

require __DIR__.'/auth.php';
