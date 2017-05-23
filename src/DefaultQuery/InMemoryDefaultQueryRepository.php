<?php

namespace CultuurNet\UDB3\ApiGuard\DefaultQuery;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use ValueObjects\StringLiteral\StringLiteral;

class InMemoryDefaultQueryRepository implements
    DefaultQueryReadRepositoryInterface,
    DefaultQueryWriteRepositoryInterface
{
    /**
     * @var StringLiteral[]
     */
    private $queries;

    /**
     * @param ApiKey $apiKey
     * @param StringLiteral $defaultQuery
     */
    public function set(ApiKey $apiKey, StringLiteral $defaultQuery)
    {
        $this->queries[$apiKey->toNative()] = $defaultQuery;
    }

    /**
     * @param ApiKey $apiKey
     * @return StringLiteral|null
     */
    public function get(ApiKey $apiKey)
    {
        if (isset($this->queries[$apiKey->toNative()])) {
            return $this->queries[$apiKey->toNative()];
        } else {
            return null;
        }
    }
}
