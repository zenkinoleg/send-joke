<?php

namespace App\Contract;

/**
 * Interface for ExternalCaller
 */
interface ExternalCallerInterface
{
    /**
     * Get Method for clients to get request
     * Return data object
     *
     * @param string $url
     * @param array $headers (optional)
     * @return object
     */
    public function endpointGetRequest(
        string $url,
        array $headers
    ) : object;
}
