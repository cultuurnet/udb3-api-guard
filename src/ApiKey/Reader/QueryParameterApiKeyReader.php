<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

class QueryParameterApiKeyReader implements ApiKeyReaderInterface
{
    /**
     * @var string
     */
    private $queryParameterName;

    /**
     * @param string $queryParameterName
     */
    public function __construct($queryParameterName)
    {
        $this->queryParameterName = (string) $queryParameterName;
    }

    public function read(ServerRequestInterface $request): ?ApiKey
    {
        $queryParams = $request->getQueryParams();

        $apiKeyAsString = $queryParams[$this->queryParameterName] ?? '';

        if ($apiKeyAsString === '') {
            return null;
        }

        return new ApiKey($apiKeyAsString);
    }
}
