<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\Consumer;

final class CultureFeedConsumerAdapter implements Consumer
{
    /**
     * @var \CultureFeed_Consumer
     */
    private $cfConsumer;

    public function __construct(\CultureFeed_Consumer $cfConsumer)
    {
        if (!isset($cfConsumer->apiKeySapi3)) {
            throw new \InvalidArgumentException('Given CultureFeed_Consumer has no "apiKeySapi3" value.');
        }

        $this->cfConsumer = clone $cfConsumer;
    }

    public function getApiKey(): ApiKey
    {
        return new ApiKey($this->cfConsumer->apiKeySapi3);
    }

    public function getDefaultQuery(): ?string
    {
        if ($this->cfConsumer->searchPrefixSapi3) {
            return $this->cfConsumer->searchPrefixSapi3;
        } else {
            return null;
        }
    }

    /**
     * @return string[]
     */
    public function getPermissionGroupIds(): array
    {
        $groupIds = is_array($this->cfConsumer->group) ? $this->cfConsumer->group : [];

        return array_map(
            function ($groupId) {
                return (string) $groupId;
            },
            $groupIds
        );
    }

    public function getName(): ?string
    {
        return  $this->cfConsumer->name;
    }

    public function isBlocked(): bool
    {
        return isset($this->cfConsumer->status) && $this->cfConsumer->status === 'BLOCKED';
    }

    public function isRemoved(): bool
    {
        return isset($this->cfConsumer->status) && $this->cfConsumer->status === 'REMOVED';
    }
}
