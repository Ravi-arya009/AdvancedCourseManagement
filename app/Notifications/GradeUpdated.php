<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GradeUpdated extends Notification
{
    use Queueable;

    protected $course;
    protected $grade;
    /**
     * Create a new notification instance.
     */
    public function __construct($course, $grade)
    {
        $this->course = $course;
        $this->grade = $grade;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Grade Has Been Updated')
            ->greeting("Hello, {$notifiable->name}")
            ->line("Your grade for the course '{$this->course->name}' has been updated.")
            ->line("New Grade: {$this->grade}")
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
