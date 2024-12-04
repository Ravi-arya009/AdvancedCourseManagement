<?php

use App\Http\Controllers\ProfileController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin_dashboard');
})->middleware(['auth', 'verified', 'role:' . Role::ADMIN])->name('admin.dashboard');

Route::get('/instructor/dashboard', function () {
    return view('instructor_dashboard');
})->middleware(['auth', 'verified', 'role:' . Role::INSTRUCTOR])->name('instructor.dashboard');


Route::get('/student/dashboard', function () {
    return view('student_dashboard');
})->middleware(['auth', 'verified', 'role:' . Role::STUDENT])->name('student.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
