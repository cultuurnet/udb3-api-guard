<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

interface ApiKeyReaderInterface
{
    public function read(ServerRequestInterface $request): ?ApiKey;
}
