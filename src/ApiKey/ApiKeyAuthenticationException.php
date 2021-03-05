<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

final class ApiKeyAuthenticationException extends \Exception
{
    public static function forApiKey(ApiKey $apiKey, string $additionalMessage = null): ApiKeyAuthenticationException
    {
        $message = 'Could not authenticate with API key "' . $apiKey->toString() . '".';

        if ($additionalMessage !== null) {
            $message .= ' ' . $additionalMessage;
        }

        return new self($message);
    }
}
