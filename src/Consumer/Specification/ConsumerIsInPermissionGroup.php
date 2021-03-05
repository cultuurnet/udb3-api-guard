<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;
use CultuurNet\UDB3\ApiGuard\ValueObjects\StringLiteral;

final class ConsumerIsInPermissionGroup implements ConsumerSpecificationInterface
{
    /**
     * @var StringLiteral
     */
    private $groupId;

    public function __construct(StringLiteral $groupId)
    {
        $this->groupId = $groupId;
    }

    public function satisfiedBy(ConsumerInterface $consumer): bool
    {
        $groupIds = $consumer->getPermissionGroupIds();

        $matching = array_filter(
            $groupIds,
            function (StringLiteral $groupId) {
                return $groupId->sameValueAs($this->groupId);
            }
        );

        return count($matching) > 0;
    }
}
