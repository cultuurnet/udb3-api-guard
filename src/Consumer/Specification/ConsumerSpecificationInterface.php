<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\ConsumerInterface;

interface ConsumerSpecificationInterface
{
    /**
     * @param ConsumerInterface $consumer
     * @return bool
     */
    public function satisfiedBy(ConsumerInterface $consumer);
}
