<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Str;

class OwnerDeletdProject extends Notification implements ShouldQueue
{
    use Queueable;

    public string $projectName;
    public string $ownerName;
    public string $ownerMail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        string $projectName,
        string $ownerName,
        string $ownerMail
    ) {
        $this->projectName = $projectName;
        $this->ownerName = $ownerName;
        $this->ownerMail = $ownerMail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting('Hello! '. $notifiable->name)
            ->from($this->ownerMail, $this->ownerName)
            ->subject(
                'Project (' .
                    Str::limit($this->projectName, 25) .
                    ') was Deleted'
            )
            ->line(
                'We Would Like to inform you that a project which you are participation to was deleted by it`s owner'
            )
            ->line('Project Name: ' . $this->projectName)
            ->line('Owner Name: ' . $this->ownerName)
            ->action('Visit your Projects page', url('/projects/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
            ];
    }
}
