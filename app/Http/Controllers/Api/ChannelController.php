<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChannelService;

class ChannelController extends Controller {
    protected $channelService;

    public function __construct(ChannelService $channelService) {
        $this->channelService = $channelService;
    }

    public function createChannel(Request $request) {
        $request->validate(['name' => 'required|string|unique:channels']);
        return response()->json($this->channelService->createChannel($request->name));
    }

    public function subscribe(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'channel_id' => 'required|exists:channels,id',
            'status' => 'required|in:active,inactive'
        ]);

        return response()->json($this->channelService->subscribeUserToChannel(
            $request->user_id, 
            $request->channel_id, 
            $request->status
        ));
    }

    public function unsubscribe(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'channel_id' => 'required|exists:channels,id',
        ]);

        return response()->json($this->channelService->unsubscribeUserFromChannel(
            $request->user_id, 
            $request->channel_id
        ));
    }

    public function activeUsers($channelId) {
        return response()->json($this->channelService->getActiveUsersByChannel($channelId));
    }
}