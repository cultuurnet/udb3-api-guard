<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

class CompositeApiKeyReader implements ApiKeyReaderInterface
{
    /**
     * @var ApiKeyReaderInterface[]
     */
    private $apiKeyReaders;

    public function __construct(ApiKeyReaderInterface ...$apiKeyReaders)
    {
        $this->apiKeyReaders = $apiKeyReaders;
    }

    public function read(ServerRequestInterface $request): ?ApiKey
    {
        foreach ($this->apiKeyReaders as $apiKeyReader) {
            $apiKey = $apiKeyReader->read($request);

            if ($apiKey) {
                return $apiKey;
            }
        }

        return null;
    }
}
