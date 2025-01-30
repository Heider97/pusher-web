<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Services\ChannelService;
use Illuminate\Support\Facades\Log;

class ProcessWebhook extends ProcessWebhookJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $channelService = new ChannelService();

        $dat = json_decode($this->webhookCall, true);
        $data = $dat['payload'];

        Log::info('Webhook received');

        foreach($data['events'] as $event) {

            Log::info(json_encode($event));

            if($event['name'] == 'member_added') {
                $channel = $channelService->createChannel($event['channel']);
                $channelService->subscribeUserToChannel($event['user_id'], $channel->id);
            } else if ($event['name'] == 'member_removed') {
                $channel = $channelService->createChannel($event['channel']);
                $channelService->unsubscribeUserFromChannel($event['user_id'], $channel->id);
            } else if ($event['name'] == 'channel_occupied') {
                $channel = $channelService->createChannel($event['channel']);
                $activeUsers = $channelService->getActiveUsersByChannel($channel->id);
                Log::info('Channel Occupied: ' . $channel->name . ' - ' . count($activeUsers) . ' active users');
            } else if ($event['name'] == 'channel_vacated'){
                $channel = $channelService->createChannel($event['channel']);
                $activeUsers = $channelService->getActiveUsersByChannel($channel->id);
                Log::info('Channel Vacated: ' . $channel->name . ' - ' . count($activeUsers) . ' active users');
            } else {
                Log::info('Unknown event: ' . $event['name']);
            }
        }

        //Acknowledge you received the response
        http_response_code(200);
    }
}
