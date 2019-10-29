<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey;

class ApiKeyAuthenticationException extends \Exception
{
    public static function cultureFeedErrorForKey(ApiKey $apiKey): ApiKeyAuthenticationException
    {
        return new self(self::messageForKey($apiKey));
    }

    public static function keyBlocked(ApiKey $apiKey): ApiKeyAuthenticationException
    {
        return new self(self::messageForKey($apiKey) . ' Key is blocked');
    }

    public static function keyRemoved(ApiKey $apiKey): ApiKeyAuthenticationException
    {
        return new self(self::messageForKey($apiKey) . ' Key is removed');
    }

    private static function messageForKey(ApiKey $apiKey): string
    {
        return 'Could not authenticate with API key "' . $apiKey->toNative() . '".';
    }
}
