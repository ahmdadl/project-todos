<?php

namespace App\Traits;

trait HasToastNotify
{
    private function showToastNotification(string $message, string $type = 'default'): void
    {
        $this->dispatchBrowserEvent(
            "notify-$type",
            (object) [
                'message' => $message,
            ]
        );
    }

    public function success(string $message)
    {
        $this->showToastNotification($message, 'success');
    }

    public function error(string $message)
    {
        $this->showToastNotification($message, 'danger');
    }

    public function warn(string $message)
    {
        $this->showToastNotification($message, 'warn');
    }

    public function info(string $message)
    {
        $this->showToastNotification($message, 'info');
    }
}
