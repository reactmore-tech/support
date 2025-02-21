<?php

namespace ReactMoreTech\Support\Adapter\Auth;

/**
 * Class BearerToken
 * 
 * BearerToken class is an implementation of the Auth interface for authenticated requests using API token.
 * 
 * @package ReactMoreTech\Support\Adapter\Auth
 */

class BearerToken implements AuthInterface
{
    /**
     * @var string The API token to be used for authentication
     */
    private $bearerToken;

    /**
     * BearerToken constructor.
     *
     * @param string $bearerToken The API token to be used for authentication
     */
    public function __construct(string $bearerToken)
    {
        $this->bearerToken = $bearerToken;
    }

    /**
     * Get the headers needed for API authentication
     *
     * @return array The headers needed for API authentication
     */
    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->bearerToken
        ];
    }
}
