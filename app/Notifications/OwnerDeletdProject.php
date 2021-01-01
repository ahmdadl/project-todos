<?php

namespace App\Notifications;

use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Messages\{MailMessage, SlackMessage};
use Str;

class OwnerDeletdProject extends ProjectNotification
{
    protected function mailMessage(
        MailMessage $mailMessage,
        $notifiable
    ): MailMessage {
        return $mailMessage
            ->greeting('Hello! ' . $notifiable->name)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->cc($this->team->pluck('email', 'name')->toArray())
            ->subject(
                'Project (' .
                    Str::limit($this->projectName, 25) .
                    ') was Deleted'
            )
            ->line(
                'We Would Like to inform you that a project which you are participation to was deleted by it`s owner'
            )
            ->line('Project Name: ' . $this->projectName)
            ->line('Owner Name: ' . $this->owner->name)
            ->action('Visit your Projects page', url('/projects/'))
            ->line('Thank you for using our application!');
    }

    protected function telegramMessage(
        TelegramMessage $telegramMessage,
        $notifiable
    ): TelegramMessage {
        return $telegramMessage
            // ->to('1181269134')
            ->content(
                "Hello there\nWe would like to notify that project was deleted\n*Project Name*: {$this->projectName}\n*Owner Name*: {$this->owner->name}"
            )
            ->button('Your Projects', url('/projects'));
    }

    protected function slackMessage(
        SlackMessage $slackMessage,
        $notifiable
    ): SlackMessage {
        return $slackMessage->content(
            "Project ({$this->projectName}) was Deleted by it`s owner ({$this->owner->name})\nTeam Members: @" .
                join(", @", $this->team->pluck('name')->toArray()) .
                ''
        );
    }
}
