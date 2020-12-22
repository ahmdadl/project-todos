<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TodoDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $id;
    public int $projectId;
    public string $body;
    public string $userName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        int $id,
        int $projectId,
        string $body,
        string $userName
    ) {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->body = $body;
        $this->userName = $userName;

        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('todos.' . $this->projectId);
    }
}
