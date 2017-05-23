<?php

namespace CultuurNet\UDB3\ApiGuard\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestAuthenticatorInterface
{
    /**
     * @param Request $request
     * @throws RequestAuthenticationException
     */
    public function authenticate(Request $request);
}
