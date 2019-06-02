<?php

namespace App\Service;

use App\Entity\ExternalCaller;

class GuzzleExternalCaller extends ExternalCaller
{

    public function __construct(
        \GuzzleHttp\Client $client
    ) {
        $this->caller = $client;
    }

    /**
     * Actual endpoint request using Guzzle
     *
     * @param string $endpoint
     * @param array $headers (optional)
     * @return object
    */
    public function endpointGetRequest(string $endpoint, array $headers = null) : object
    {
        if (!$headers) {
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
        }
        try {
            $response = $this->caller
                ->request('GET', $endpoint, [ 'headers' => $headers ])
                ->getBody()
                ->getContents();
        } catch (\Exception $e) {
            throw new \Exception("External endpoint ($url) loading problem: " . $e->getMessage());
        }
        return json_decode($response);
    }

    /**
     * Parse and check if response from ICNDB is valid
     * Should be coupled with Joker class at some point
     *
     * @param object $data
     * @return object
    */
    public function parseResponse(object $data) : object
    {
        if ($data->type != 'success' || !isset($data->value)) {
            throw new \Exception('Invalid Data Object');
        }
        return (object) $data->value;
    }
}
