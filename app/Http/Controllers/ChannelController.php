<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Services\ChannelService;
use App\Events\ChannelMessageSent;
use App\Models\MissedMessage;

class ChannelController extends Controller {
    protected $channelService;

    public function __construct(ChannelService $channelService) {
        $this->channelService = $channelService;
    }

    public function getChannelsWithActiveUsers() {
        $channels = Channel::with(['users' => function ($query) {
            $query->wherePivot('status', 'active');
        }])->get();

        return response()->json($channels);
    }

    public function sendMessageToActiveUsers(Request $request, $channelId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $channel = Channel::findOrFail($channelId);
        $users = $channel->users;
    
        foreach ($users as $user) {
            if ($user->pivot->status === 'active') {
                broadcast(new ChannelMessageSent($request->message, $channel->name, $user));
            } else {
                // Store missed message
                MissedMessage::create([
                    'user_id' => $user->id,
                    'channel_id' => $channel->id,
                    'message' => $request->message,
                    'sent' => false,
                ]);
            }
        }

        return response()->json(['message' => 'Event sent to active users']);
    }

    
}