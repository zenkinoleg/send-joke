<?php

namespace App\Entity;

use App\Contract\ExternalCallerInterface;

class ExternalCaller implements ExternalCallerInterface
{

    /**
     * Must be init by implementing class via constructor
    */
    protected $caller;

    /**
     * Client method for getting request
     *
     * @param string $url
     * @param array $headers (optional)
     * @return object
    */
    public function get(string $url, array $headers) : array
    {
        return $this->caller->endpointGetRequest($url, $headers);
    }

    /**
     * Actual endpoint Request
     * Supposed to be overriden
     *
     * @param string $url
     * @param array $headers (optional)
     * @return object
    */
    public function endpointGetRequest(string $url, array $headers) : object
    {
        return (object) [];
    }
}
