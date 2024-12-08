<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{

    public function run()
    {
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            // Check if this student-course pair already has a grade
            if (Grade::where('student_id', $enrollment->student_id)->where('course_id', $enrollment->course_id)->doesntExist()) {
                Grade::create([
                    'student_id' => $enrollment->student_id,
                    'course_id' => $enrollment->course_id,
                    'grade' => $this->generateRandomGrade(),
                ]);
            }
        }
    }

    /**
     * Generate a random grade.
     *
     * @return string
     */
    private function generateRandomGrade()
    {
        $grades = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
        return $grades[array_rand($grades)];
    }
}
