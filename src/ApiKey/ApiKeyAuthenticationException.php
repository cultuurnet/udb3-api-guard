<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

class ApiKeyAuthenticationException extends \Exception
{
    public static function forApiKey(ApiKey $apiKey, string $additionalMessage = null): ApiKeyAuthenticationException
    {
        $message = 'Could not authenticate with API key "' . $apiKey->toNative() . '".';

        if ($additionalMessage !== null) {
            $message .= ' ' . $additionalMessage;
        }

        return new self($message);
    }
}
