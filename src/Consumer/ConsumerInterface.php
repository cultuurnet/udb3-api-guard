<?php

namespace CultuurNet\UDB3\ApiGuard\Consumer;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use ValueObjects\StringLiteral\StringLiteral;

interface ConsumerInterface
{
    /**
     * @return ApiKey
     */
    public function getApiKey();

    /**
     * @return StringLiteral|null
     */
    public function getDefaultQuery();
}
