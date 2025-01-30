<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Services\ChannelService;

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
}