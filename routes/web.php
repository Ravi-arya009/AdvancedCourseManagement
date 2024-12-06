<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/home', [CourseController::class, 'home'])->middleware(['auth', 'verified', 'role:' . Role::INSTRUCTOR])->name('home');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified', 'role:' . Role::ADMIN])->name('admin.dashboard');


Route::middleware(['auth', 'verified', 'role:' . Role::ADMIN])->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/admin/user_list', [UserController::class, 'list'])->name('user.list');
    Route::get('/admin/create_user', [UserController::class, 'create'])->name('user.create');
    Route::post('/admin/create_user', [UserController::class, 'store'])->name('user.store');
    Route::get('/admin/edit_user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/admin/edit_user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/admin/delete_user/{id}', [UserController::class, 'delete'])->name('user.delete');

});



Route::middleware(['auth', 'verified', 'role:' . Role::INSTRUCTOR])->group(function () {

    Route::get('/instructor/create_course', [CourseController::class, 'create'])->name('course.create');
    Route::post('/instructor/create_course', [CourseController::class, 'store'])->name('course.store');

    Route::get('/instructor/edit_course/{course}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/instructor/edit_course/{course}', [CourseController::class, 'update'])->name('course.update');

    Route::get('/instructor/course_list', [CourseController::class, 'list'])->name('course.list');
    Route::delete('/instructor/delete_course/{id}', [CourseController::class, 'delete'])->name('course.delete');

    Route::get('/instructor/course/{course}/students', [CourseController::class, 'viewStudents'])->name('course.view_students');

    Route::post('/instructor/course/{course}/update_grades', [CourseController::class, 'updateGrades'])->name('grade.update');



    Route::get('/instructor/dashboard', function () {
        return view('instructor_dashboard');
    })->name('instructor.dashboard');
});



Route::middleware(['auth', 'verified', 'role:' . Role::STUDENT])->group(function () {

    Route::get('/student/course_list', [CourseController::class, 'index'])->name('course.list');
    Route::get('/student/course_details/{id}', [CourseController::class, 'details'])->name('course.details');

    Route::post('/student/enroll/{course}', [CourseController::class, 'enroll'])->name('course.enroll');

    Route::get('/student/my_courses', [CourseController::class, 'myCourses'])->name('student.courses');


    Route::get('/student/dashboard', function () {
        return view('student_dashboard');
    })->name('student.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
