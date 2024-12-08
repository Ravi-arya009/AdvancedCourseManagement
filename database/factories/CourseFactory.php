<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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
            'Introduction to Artificial Intelligence',
            'Full-Stack JavaScript Development',
            'Foundations of Business Analytics',
            'Mobile App Development with Flutter',
            'Introduction to Blockchain Technology',
            'Ethical Hacking and Penetration Testing',
            'Social Media Marketing Strategies',
            'Photography and Image Editing Basics',
            'Advanced SQL and Database Optimization',
            'Video Editing with Premiere Pro',
            'Basics of Game Development with Unity',
            'Introduction to Augmented Reality (AR)',
            'Modern Software Engineering Practices',
            'Time Management and Productivity Hacks',
            'Environmental Science and Sustainability',
        ];


        foreach ($courseTitles as $title){
            return [
                'title' => $title,
                'description' => $this->faker->paragraph(),
                'instructor_id' => rand(2,6),
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }
    }
}
