<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

final class CustomHeaderApiKeyReader implements ApiKeyReaderInterface
{
    /**
     * @var string
     */
    private $headerName;

    public function __construct(string $headerName)
    {
        $this->headerName = $headerName;
    }

    public function read(ServerRequestInterface $request): ?ApiKey
    {
        $apiKeys = $request->getHeader($this->headerName);

        if ($apiKeys === []) {
            return null;
        }

        return new ApiKey(reset($apiKeys));
    }
}
