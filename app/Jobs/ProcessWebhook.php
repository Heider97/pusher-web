<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Services\ChannelService;

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

        foreach($data['events'] as $event) {
            if($event == 'member_added') {
                $channel = $channelService->createChannel($event['channel']);
                $channelService->subscribeUserToChannel($event['user_id'], $channel->id);
            } else if ($event == 'member_removed') {
                $channel = $channelService->createChannel($event['channel']);
                $channelService->unsubscribeUserFromChannel($event['user_id'], $channel->id);
            }
        }

        //Acknowledge you received the response
        http_response_code(200);
    }
}
