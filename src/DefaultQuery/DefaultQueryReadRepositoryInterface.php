<?php

namespace CultuurNet\UDB3\ApiGuard\DefaultQuery;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use ValueObjects\StringLiteral\StringLiteral;

interface DefaultQueryReadRepositoryInterface
{
    /**
     * @param ApiKey $apiKey
     * @return StringLiteral|null
     */
    public function get(ApiKey $apiKey);
}
