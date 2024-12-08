<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['role_name' => 'Admin']);
        Role::create(['role_name' => 'Instructor']);
        Role::create(['role_name' => 'Student']);

        //adding admin
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@gmail.com',
            'password'=>'12345678',
            'role_id' => 1
        ]);

        //adding 5 instructors
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'name' => "Test Instructor $i",
                'email' => "instructor$i@gmail.com",
                'password' => '12345678',
                'role_id' => 2,
            ]);
        }

        //adding 10 students
        for ($i = 1; $i <= 20; $i++) {
            User::factory()->create([
                'name' => "Test Student $i",
                'email' => "student$i@gmail.com",
                'password' => '12345678',
                'role_id' => 3,
            ]);
        }

        //adding courses
        $courseTitles = [
            'Introduction to Web Development',
            'Advanced Python Programming',
            'Data Science with R',
            'Mastering Machine Learning',
            'Digital Marketing Basics',
            'Graphic Design for Beginners',
            'Project Management Essentials',
            'Cybersecurity Fundamentals',
            'Creative Writing Workshop',
            'Cloud Computing with AWS',
        ];

        $faker = \Faker\Factory::create();

        foreach ($courseTitles as $title) {
            Course::factory()->create([
                'title' => $title,
                'description' => $faker->paragraph(),
                'instructor_id' => rand(2, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        //enrolling students to the courses
        $this->call([
            EnrollmentSeeder::class,
        ]);

        //seeding grades
        $this->call([
            GradeSeeder::class,
        ]);
    }
}
