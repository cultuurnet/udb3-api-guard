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
        return in_array(
            $this->groupId,
            $consumer->getPermissionGroupIds()
        );
    }
}
