<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedSuccessful extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $usersEmail; 
    public function __construct($usersEmail)
    {
        $this->usersEmail = $usersEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('User Creation Notification')
                    ->action('Notification Action', url('/users/lists?s='. $this->usersEmail))
                    ->line('User "'. $this->usersEmail.'" is created successful at your system.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => 'User "'. $this->usersEmail.'" is created successful at your system.'
        ];
    }
}
