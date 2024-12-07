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
        // User::factory(10)->create();

        Role::create(['role_name' => 'Admin']);
        Role::create(['role_name' => 'Instructor']);
        Role::create(['role_name' => 'Student']);

        // User::factory()->create([
        //     'name' => 'Test Admin',
        //     'email' => 'admin@email.com',
        //     'password'=>'raviarya',
        //     'role_id' => 1
        // ]);

        //adding Instructors
        // User::factory()->create([
        //     'name' => 'Test Instructor',
        //     'email' => 'instructor@email.com',
        //     'password' => 'raviarya',
        //     'role_id' => 2
        // ]);

        // User::factory()->create([
        //     'name' => 'Test Instructor 2',
        //     'email' => 'instructor2@email.com',
        //     'password' => 'raviarya',
        //     'role_id' => 2
        // ]);

        // User::factory()->create([
        //     'name' => 'Test Instructor 3',
        //     'email' => 'instructor3@email.com',
        //     'password' => 'raviarya',
        //     'role_id' => 2
        // ]);


        //adding students
        // User::factory()->create([
        //     'name' => 'Test Student',
        //     'email' => 'student@email.com',
        //     'password' => 'raviarya',
        //     'role_id' => 3
        // ]);

        // User::factory()->create([
        //     'name' => 'Test Student2',
        //     'email' => 'student2@email.com',
        //     'password' => 'raviarya',
        //     'role_id' => 3
        // ]);

        // User::factory()->create([
        //     'name' => 'Test Student3',
        //     'email' => 'student3@email.com',
        //     'password' => 'raviarya',
        //     'role_id' => 3
        // ]);

        //adding courses
        // Course::factory(10)->create();
    }
}
