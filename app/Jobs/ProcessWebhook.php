<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Support\Facades\Log;
use App\Models\Post;

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
        $dat = json_decode($this->webhookCall, true);
        $data = $dat['payload'];

        $post = new Post([
            'title' => 'Webhook',
            'body' => 'Webhook received',
        ]);

        $post->save();
    
        if ($data['event'] == 'charge.success') {
          // take action since the charge was success
          // Create order
          // Sed email
          // Whatever you want
          Log::info($data);
        }

        //Acknowledge you received the response
        http_response_code(200);
    }
}
