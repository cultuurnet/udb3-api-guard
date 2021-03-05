<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;
use CultuurNet\UDB3\ApiGuard\ValueObjects\StringLiteral;

final class CultureFeedConsumerAdapter implements ConsumerInterface
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

    public function getDefaultQuery(): ?StringLiteral
    {
        if ($this->cfConsumer->searchPrefixSapi3) {
            return new StringLiteral($this->cfConsumer->searchPrefixSapi3);
        } else {
            return null;
        }
    }

    /**
     * @return StringLiteral[]
     */
    public function getPermissionGroupIds(): array
    {
        $groupIds = is_array($this->cfConsumer->group) ? $this->cfConsumer->group : [];

        return array_map(
            function ($groupId) {
                return new StringLiteral((string) $groupId);
            },
            $groupIds
        );
    }

    public function getName(): ?string
    {
        return  $this->cfConsumer->name;
    }
}
