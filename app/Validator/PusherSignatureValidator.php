<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class PusherSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $webhookConfig): bool
    {
        $signature = $request->header($webhookConfig->signatureHeaderName);

        Log::info($webhookConfig->signatureHeaderName);

        $body = $request->getContent();

        Log::info(json_encode($body));

        $secret = env('WEBHOOK_CLIENT_SECRET');

        Log::info($secret);

        $hash = hash_hmac('sha256', $body, $secret);

        Log::info($signature);
        Log::info($hash);

        if ($signature !== $hash) {
            Log::error('Invalid signature');
            return false;
        }

        return true;
    }
}