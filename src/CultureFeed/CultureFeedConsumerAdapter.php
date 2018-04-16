<?php

namespace CultuurNet\UDB3\ApiGuard\CultureFeed;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;
use ValueObjects\StringLiteral\StringLiteral;

class CultureFeedConsumerAdapter implements ConsumerInterface
{
    /**
     * @var \CultureFeed_Consumer
     */
    private $cfConsumer;

    /**
     * @param \CultureFeed_Consumer $cfConsumer
     */
    public function __construct(\CultureFeed_Consumer $cfConsumer)
    {
        if (!isset($cfConsumer->apiKeySapi3)) {
            throw new \InvalidArgumentException('Given CultureFeed_Consumer has no "apiKeySapi3" value.');
        }

        $this->cfConsumer = clone $cfConsumer;
    }

    /**
     * @inheritdoc
     */
    public function getApiKey()
    {
        return new ApiKey($this->cfConsumer->apiKeySapi3);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultQuery()
    {
        if ($this->cfConsumer->searchPrefixSapi3) {
            return new StringLiteral($this->cfConsumer->searchPrefixSapi3);
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function getPermissionGroupIds()
    {
        $groupIds = is_array($this->cfConsumer->group) ? $this->cfConsumer->group : [];

        return array_map(
            function ($groupId) {
                return new StringLiteral((string) $groupId);
            },
            $groupIds
        );
    }
}
