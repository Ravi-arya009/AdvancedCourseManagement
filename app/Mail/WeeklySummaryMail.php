<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WeeklySummaryMail extends Mailable
{
    public $course;
    public $instructor;
    public $summary;

    public function __construct($course, $instructor, $summary)
    {
        $this->course = $course;
        $this->instructor = $instructor;
        $this->summary = $summary;
    }

    public function build()
    {
        return $this->subject('Weekly Summary for ' . $this->course->title)
            ->view('weekly_summary');
    }
}
