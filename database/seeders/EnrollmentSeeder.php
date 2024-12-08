<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{

    public function run(): void
    {
        $students = User::all()->where('role_id', 3);
        $courses = Course::all();

        foreach ($students as $student) {
            $course = $courses->random();  // Pick a random course
            // Check if the student is already enrolled in this course
            if (DB::table('enrollments')->where('student_id', $student->id)->where('course_id', $course->id)->doesntExist()) {
                DB::table('enrollments')->insert([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'enrollment_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
