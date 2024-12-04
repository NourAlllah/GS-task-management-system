<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tasks/create', [TaskController::class, 'create_page'])->name('tasks.create.page');
Route::post('/tasks', [TaskController::class, 'create'])->name('tasks.create');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update_status');
/* Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
 */
Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');

use App\Mail\AchievementUnlocked;
use Illuminate\Support\Facades\Mail;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
