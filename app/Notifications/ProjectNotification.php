<?php

namespace App\Notifications;

use App\Models\User;
use NotificationChannels\Telegram\{TelegramChannel, TelegramMessage};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\{MailMessage, SlackMessage};
use Illuminate\Notifications\Notification;

abstract class ProjectNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $owner;
    public string $projectName;
    public ?Collection $team;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        User $owner,
        string $projectName,
        ?Collection $team = null
    ) {
        $this->owner = $owner;
        $this->projectName = $projectName;
        $this->team = $team;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class, 'mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  \App\Models\User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = new MailMessage();
        return $this->mailMessage($mail, $notifiable);
    }

    public function toTelegram($notifiable)
    {
        $telegram = TelegramMessage::create();

        return $this->telegramMessage($telegram, $notifiable);
    }

    public function toSlack($notifiable)
    {
        $slack = new SlackMessage();

        return $this->slackMessage($slack, $notifiable);
    }

    abstract protected function mailMessage(
        MailMessage $mailMessage,
        $notifiable
    ): MailMessage;

    abstract protected function telegramMessage(
        TelegramMessage $telegramMessage,
        $notifiable
    ): TelegramMessage;

    abstract protected function slackMessage(
        SlackMessage $slackMessage,
        $notifiable
    ): SlackMessage;
}
