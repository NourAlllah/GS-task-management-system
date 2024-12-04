<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Mail;

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
Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/send-test-email', function () {
    $data = [
        'name' => 'John Doe',
        'message' => 'This is a test email from your Laravel application',
    ];

    Mail::send('emails.test', $data, function ($message) {
        $message->to('nourabase1998@gmail.com', 'Recipient Name')
               ->subject('Test Email from Laravel');
    });

    return 'Test email sent!';
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
