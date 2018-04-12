<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;
use ValueObjects\StringLiteral\StringLiteral;

class ConsumerIsInPermissionGroup implements ConsumerSpecificationInterface
{
    /**
     * @var StringLiteral
     */
    private $groupId;

    /**
     * @param StringLiteral $groupId
     */
    public function __construct(StringLiteral $groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @inheritdoc
     */
    public function satisfiedBy(ConsumerInterface $consumer)
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
