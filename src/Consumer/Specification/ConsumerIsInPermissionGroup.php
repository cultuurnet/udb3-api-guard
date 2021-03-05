<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;

final class ConsumerIsInPermissionGroup implements ConsumerSpecificationInterface
{
    /**
     * @var string
     */
    private $groupId;

    public function __construct(string $groupId)
    {
        $this->groupId = $groupId;
    }

    public function satisfiedBy(ConsumerInterface $consumer): bool
    {
        $groupIds = $consumer->getPermissionGroupIds();

        $matching = array_filter(
            $groupIds,
            function (string $groupId) {
                return $groupId === $this->groupId;
            }
        );

        return count($matching) > 0;
    }
}
