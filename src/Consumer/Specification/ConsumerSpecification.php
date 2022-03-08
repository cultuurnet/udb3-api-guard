<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Consumer\Specification;

use CultuurNet\UDB3\ApiGuard\Consumer\Consumer;

interface ConsumerSpecification
{
    public function satisfiedBy(Consumer $consumer): bool;
}
