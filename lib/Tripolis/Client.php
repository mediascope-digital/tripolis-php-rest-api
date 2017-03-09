<?php

namespace Tripolis;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use Tripolis\Api;

class Client
{
    /**
     * Tripolis API version.
     */
    const API_VARSION = '1.0';

    /**
     * Tripolis API datacenter.
     *
     * @var string
     */
    private $apiDatacenter;

    /**
     * Tripolis API username.
     *
     * @var string
     */
    private $apiUsername;

    /**
     * Tripolis API key.
     *
     * @var string
     */
    private $apiKey;

    /**
     * Tripolis API endpoint.
     *
     * @var string
     */
    private $apiEndpoint = 'https://<dc>.tripolis.com/api3/rest/';

    /**
     * Http client.
     *
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * Constructor.
     *
     * @param string $apiDatacenter Tripolis API datacenter.
     * @param string $apiUsername   Tripolis API username.
     * @param string $apiKey        Tripolis API key.
     * @param array  $httpOptions   Http client options.
     */
    public function __construct($apiDatacenter, $apiUsername, $apiKey, array $httpOptions = [])
    {
        $this->apiDatacenter = $this->getDatacenter($apiDatacenter);
        $this->apiUsername = $apiUsername;
        $this->apiKey = $apiKey;
        $this->apiEndpoint = str_replace('<dc>', $this->apiDatacenter, $this->apiEndpoint);

        $config = array_merge([
            'base_uri' => $this->apiEndpoint,
            'allow_redirects' => false,
            'auth' => [
                $this->apiUsername,
                $this->apiKey,
            ],
        ], $httpOptions);

        $this->httpClient = new HttpClient($config);
    }

    /**
     * Creates a Tripolis client.
     *
     * @param string $apiDatacenter Tripolis API datacenter.
     * @param string $apiUsername   Tripolis API username.
     * @param string $apiKey        Tripolis API key.
     * @param array  $httpOptions   Http client options.
     *
     * @return Client
     */
    public static function create($apiDatacenter, $apiUsername, $apiKey, array $httpOptions = [])
    {
        return new static($apiDatacenter, $apiUsername, $apiKey, $httpOptions);
    }

    /**
     * Retruns the API datacenter.
     *
     * @return string
     */
    public function getApiDatacenter()
    {
        return $this->apiDatacenter;
    }

    /**
     * Retruns the API username.
     *
     * @return string
     */
    public function getApiUsername()
    {
        return $this->apiUsername;
    }

    /**
     * Retruns the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Retruns the API endpoint.
     *
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * [api description]
     *
     * @param  string $name [description]
     *
     * @return [type]       [description]
     */
    public function api($name)
    {
        switch ($name) {
            case 'contactDatabases':
            case 'contactdatabases':
                $api = new Api\ContactDatabase($this);
                break;
        }

        return $api;
    }

    /**
     * Returns the Http client.
     *
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Returns the Tripolis API datacenter.
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the given datacenter ins not valid.
     */
    private function getDatacenter($datacenter)
    {
        $dc = $datacenter;
        if (preg_match('/^[0-9]{2}$/', $datacenter)) {
            $dc = sprintf('td%d', $datacenter);
        }
        if (!preg_match('/^td[0-9]{2}$/', $dc)) {
            throw new \InvalidArgumentException(sprintf('The given datacenter "%s" is invalid.', $datacenter));
        }

        return $dc;
    }
}
