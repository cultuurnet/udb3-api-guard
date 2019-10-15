<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

class CustomHeaderApiKeyReader implements ApiKeyReaderInterface
{
    /**
     * @var string
     */
    private $headerName;

    /**
     * @param string $headerName
     */
    public function __construct($headerName)
    {
        $this->headerName = (string) $headerName;
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
