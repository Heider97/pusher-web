<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ChannelMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $channelName;
    public $user;

    public function __construct($message, $channelName, User $user)
    {
        $this->message = $message;
        $this->channelName = $channelName;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('channel.' . $this->channelName);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
}
