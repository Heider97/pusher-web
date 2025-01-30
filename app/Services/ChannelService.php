<?php

namespace App\Services;

use App\Models\Channel;
use App\Models\ChannelSubscription;
use App\Models\User;

class ChannelService
{
    public function createChannel($name)
    {
        return Channel::firstOrCreate(['name' => $name]);
    }

    public function subscribeUserToChannel($userId, $channelId, $status = 'active')
    {
        return ChannelSubscription::updateOrCreate(
            ['user_id' => $userId, 'channel_id' => $channelId],
            ['status' => $status]
        );
    }

    public function unsubscribeUserFromChannel($userId, $channelId)
    {
        return ChannelSubscription::where('user_id', $userId)
            ->where('channel_id', $channelId)
            ->delete();
    }

    public function getActiveUsersByChannel($channelId)
    {
        return ChannelSubscription::where('channel_id', $channelId)
            ->where('status', 'active')
            ->with('user')
            ->get();
    }
}
