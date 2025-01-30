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

        $content = $request->getContent();
        $body = trim($content);

        $secret = env('WEBHOOK_CLIENT_SECRET');
        $hash = hash_hmac('sha256', $body, $secret);

        if ($signature !== $hash) {
            Log::error('Invalid signature');
            return false;
        }

        return true;
    }
}