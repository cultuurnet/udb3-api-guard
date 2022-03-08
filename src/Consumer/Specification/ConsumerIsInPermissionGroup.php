<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\Consumer;

final class ConsumerIsInPermissionGroup implements ConsumerSpecification
{
    private string $groupId;

    public function __construct(string $groupId)
    {
        $this->groupId = $groupId;
    }

    public function satisfiedBy(Consumer $consumer): bool
    {
        return in_array(
            $this->groupId,
            $consumer->getPermissionGroupIds(),
            true
        );
    }
}
