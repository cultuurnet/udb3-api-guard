<?php

declare(strict_types=1);

namespace CultuurNet\UDB3\ApiGuard\Request;

use Psr\Http\Message\ServerRequestInterface;

interface RequestAuthenticator
{
    public function authenticate(ServerRequestInterface $request): void;
}
