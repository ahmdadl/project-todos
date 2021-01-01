<?php

namespace App\Notifications;

use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Str;

class AddedToProjectTeam extends ProjectNotification
{
    protected function mailMessage(
        MailMessage $mailMessage,
        $notifiable
    ): MailMessage {
        return $mailMessage
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

    protected function telegramMessage(
        TelegramMessage $telegramMessage,
        $notifiable
    ): TelegramMessage {
        return $telegramMessage
            // ->to('1181269134')
            ->content(
                "Hello there\n*{$notifiable->name}* was added to project team.\n*Project Name*: {$this->projectName}\n*Owner Name*: {$this->owner->name}"
            )
            ->button(
                'Visit Project',
                url('/projects/' . Str::slug($this->projectName))
            )
            ->button('Your Projects', url('/projects'));
    }

    protected function slackMessage(
        SlackMessage $slackMessage,
        $notifiable
    ): SlackMessage {
        return $slackMessage
            ->content("user ({$notifiable->name}) was added as project team member.\nProject Name: {$this->projectName}\nOwner Name: {$this->owner->name}");
    }
}
