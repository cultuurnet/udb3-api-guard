<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\CultureFeed\CultureFeedConsumerAdapter;
use ICultureFeed;

final class CultureFeedConsumerReadRepository implements ConsumerReadRepository
{
    private ICultureFeed $cultureFeed;
    private bool $includePermissions;

    public function __construct(
        ICultureFeed $cultureFeed,
        bool $includePermissions
    ) {
        $this->cultureFeed = $cultureFeed;
        $this->includePermissions = $includePermissions;
    }

    public function getConsumer(ApiKey $apiKey): ?Consumer
    {
        try {
            $consumer = $this->cultureFeed->getServiceConsumerByApiKey(
                $apiKey->toString(),
                $this->includePermissions
            );
            return new CultureFeedConsumerAdapter($consumer);
        } catch (\Exception $e) {
            return null;
        }
    }
}
