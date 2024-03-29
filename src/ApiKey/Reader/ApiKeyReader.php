<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Psr\Http\Message\ServerRequestInterface;

interface ApiKeyReader
{
    public function read(ServerRequestInterface $request): ?ApiKey;
}
