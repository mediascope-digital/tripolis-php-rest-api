<?php

namespace Tripolis\Api;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use Tripolis\Client;

abstract class AbstractApi implements ApiInterface
{
    /**
     * Tripolis client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Http client GET shortcut.
     *
     * @param string $uri     The URI
     * @param array  $options Request options to apply
     *
     * @return object
     */
    protected function get($uri, array $options = [])
    {
        return $this->request('GET', $uri, $options);
    }

    /**
     * Http client PUT shortcut.
     *
     * @param string $uri     The URI
     * @param array  $options Request options to apply
     *
     * @return object
     */
    protected function put($uri, array $options = [])
    {
        return $this->request('PUT', $uri, $options);
    }

    /**
     * Http client POST shortcut.
     *
     * @param string $uri     The URI
     * @param array  $options Request options to apply
     *
     * @return object
     */
    protected function post($uri, array $options = [])
    {
        return $this->request('POST', $uri, $options);
    }

    /**
     * Http client PATCH shortcut.
     *
     * @param string $uri     The URI
     * @param array  $options Request options to apply
     *
     * @return object
     */
    protected function patch($uri, array $options = [])
    {
        return $this->request('PATCH', $uri, $options);
    }

    /**
     * Http client DELETE shortcut.
     *
     * @param string $uri     The URI
     * @param array  $options Request options to apply
     *
     * @return object
     */
    protected function delete($uri, array $options = [])
    {
        return $this->request('DELETE', $uri, $options);
    }

    /**
     * Http client request.
     *
     * @param string $method  HTTP method
     * @param string $uri     The URI
     * @param array  $options Request options to apply
     *
     * @return object
     */
    protected function request($method, $uri, array $options = [])
    {
        try {
            $response = $this->client->getHttpClient()->request($method, $uri, $options);
            $body = (string) $response->getBody();

            if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
                return GuzzleHttp\json_decode($body);
            }

            return $body;
        } catch (RequestException $e) {
            echo($e->getMessage());die;
        }
    }
}
