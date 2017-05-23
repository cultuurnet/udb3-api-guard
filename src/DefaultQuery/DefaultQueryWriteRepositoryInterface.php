<?php

namespace CultuurNet\UDB3\ApiGuard\DefaultQuery;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use ValueObjects\StringLiteral\StringLiteral;

interface DefaultQueryWriteRepositoryInterface
{
    /**
     * @param ApiKey $apiKey
     * @param StringLiteral $defaultQuery
     */
    public function set(ApiKey $apiKey, StringLiteral $defaultQuery);
}
