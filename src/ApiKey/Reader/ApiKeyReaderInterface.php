<?php

namespace CultuurNet\UDB3\ApiGuard\ApiKey\Reader;

use CultuurNet\UDB3\ApiGuard\ApiKey\ApiKey;
use Symfony\Component\HttpFoundation\Request;

interface ApiKeyReaderInterface
{
    /**
     * @param Request $request
     * @return ApiKey|null
     */
    public function read(Request $request);
}
