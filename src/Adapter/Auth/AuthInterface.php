<?php

namespace ReactMoreTech\Support\Adapter\Auth;

/**
 * The interface for all authentication implementations.
 */
interface AuthInterface
{
    /**
     * Returns an array of headers required for authentication.
     *
     * @return array The headers required for authentication.
     */
    public function getHeaders(): array;
}
