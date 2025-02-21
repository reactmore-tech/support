<?php

namespace ReactMoreTech\Support\Adapter\Auth;

/**
 * Class None
 * Implementation of the Auth interface for unauthenticated requests.
 * 
 * This class returns an empty array for the headers as there is no authentication required for the API request.
 *
 * @package ReactMoreTech\Support\Adapter\Auth
 */

class None implements AuthInterface
{
    /**
     * Returns empty headers as no authentication is needed.
     *
     * @return array Empty headers.
     */
    public function getHeaders(): array
    {
        return [];
    }
}

