<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;

interface ConsumerSpecificationInterface
{
    public function satisfiedBy(ConsumerInterface $consumer): bool;
}
