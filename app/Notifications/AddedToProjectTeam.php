<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Str;

class AddedToProjectTeam extends Notification implements ShouldQueue
{
    use Queueable;

    public User $owner;
    public string $projectName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $owner, string $projectName)
    {
        $this->owner = $owner;
        $this->projectName = $projectName;
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
     * @param  \App\Models\User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting('Hello! ' . $notifiable->name)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Project Team New Member')
            ->line(
                'We would like to inform you that you was added as team member for project (' .
                    Str::limit($this->projectName, 25) .
                    ').'
            )
            ->line(
                'you can now see this project at your projects page, and modify it as you like.'
            )
            ->line('Project Name: ' . $this->projectName)
            ->line('Owner Name: ' . $this->owner->name)
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
