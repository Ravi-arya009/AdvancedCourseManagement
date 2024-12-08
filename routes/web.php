<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Routes For Admin
Route::middleware(['auth', 'verified', 'role:' . Role::ADMIN])->prefix('admin')->group(function () {

    Route::get('/user_list', [UserController::class, 'list'])->name('user.list');

    Route::get('/create_user', [UserController::class, 'create'])->name('user.create');
    Route::post('/create_user', [UserController::class, 'store'])->name('user.store');

    Route::get('/edit_user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/edit_user/{user}', [UserController::class, 'update'])->name('user.update');

    Route::delete('/delete_user/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::get('/top_students_select_course', [CourseController::class, 'top_students_select_course'])->name('topStudents.SelectCourse');
    Route::get('/top_students/{courseId}/{courseName}', [CourseController::class, 'top_students_view'])->name('students.top');

    Route::get('/top_courses_select_instructor', [CourseController::class, 'top_courses_select_instructor'])->name('topCourses.SelectInstructor');
    Route::get('/top_courses/{instructorId}/{instructorName}', [CourseController::class, 'top_course_view'])->name('courses.top');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

//Routes For Instructor
Route::middleware(['auth', 'verified', 'role:' . Role::INSTRUCTOR])->prefix('instructor')->group(function () {

    Route::get('/create_course', [CourseController::class, 'create'])->name('course.create');
    Route::post('/create_course', [CourseController::class, 'store'])->name('course.store');

    Route::get('/edit_course/{course}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/edit_course/{course}', [CourseController::class, 'update'])->name('course.update');

    Route::get('/course_list', [CourseController::class, 'list'])->name('instructor.course.list');
    Route::delete('/delete_course/{id}', [CourseController::class, 'delete'])->name('course.delete');

    Route::get('/course/{course}/students', [CourseController::class, 'viewStudents'])->name('course.view_students');
    Route::post('/course/{course}/update_grades', [CourseController::class, 'updateGrades'])->name('grade.update');

    Route::get('/csv_course_list/', [CourseController::class, 'csv_course_list'])->name('csvcourse.list');
    Route::post('/courses/{course}/enroll_csv', [CourseController::class, 'enrollCSV'])->name('courses.enroll_csv');

    Route::get('/dashboard', function () {
        return view('instructor.dashboard');
    })->name('instructor.dashboard');
});

//Routes For Student
Route::middleware(['auth', 'verified', 'role:' . Role::STUDENT])->prefix('student')->group(function () {

    Route::get('/course_list', [CourseController::class, 'index'])->name('course.list');
    Route::get('/course_details/{id}', [CourseController::class, 'details'])->name('course.details');
    Route::post('/enroll/{course}', [CourseController::class, 'enroll'])->name('course.enroll');
    Route::get('/my_courses', [CourseController::class, 'myCourses'])->name('student.courses');

    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

require __DIR__ . '/auth.php';
