<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

final class QueryParameterApiKeyReader implements ApiKeyReader
{
    private string $queryParameterName;

    public function __construct(string $queryParameterName)
    {
        $this->queryParameterName = $queryParameterName;
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
