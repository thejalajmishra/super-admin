<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleCreatedSuccessful extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $roleName; 
    public function __construct($roleName)
    {
        $this->roleName = $roleName;
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
                    ->line('Role Creation Notification')
                    ->action('Notification Action', url('/roles/lists?s='. $this->roleName))
                    ->line('Role "'. $this->roleName.'" is created successful at your system.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => 'Role "'. $this->roleName.'" is created successful at your system.'
        ];
    }
}
