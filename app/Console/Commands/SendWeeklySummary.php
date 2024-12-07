<?php

namespace App\Console\Commands;

use App\Mail\WeeklySummaryMail;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWeeklySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weekly-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly summary email to instructors';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $courses = Course::with(['instructor', 'grades'])->get();
        $count = 0;
        foreach ($courses as $course) {
            $instructor = $course->instructor;

            if ($instructor) {
                $count++;

                $summary = $course->students->map(function ($student) use ($course) {
                    $grade = $student->grades->where('course_id', $course->id)->first();
                    return [
                        'name' => $student->name,
                        'email' => $student->email,
                        'grade' => $grade ? $grade->grade : 'N/A',
                    ];
                });
            }

            //logging the data first for debugging purposes.
            //Since using free mailing service, if the mail fails, logs can be checked.
            Log::info('Weekly Summary for Course: ' . $course->title, [
                'instructor' => $instructor->name,
                'summary' => $summary
            ]);
            //sending mail.(using mailtrap service)
            Mail::to($instructor->email)->send(new WeeklySummaryMail($course, $instructor, $summary));
        }

        $this->info('Weekly summary emails sent successfully.dddd');
    }
}
