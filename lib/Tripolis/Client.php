<?php

namespace Tripolis;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use Tripolis\Api;

class Client
{
    /**
     * Tripolis api version.
     */
    const API_VARSION = '1.0';

    /**
     * Tripolis API endpoint.
     *
     * @var string
     */
    private $apiEndpoint;

    /**
     * Http client.
     *
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * Constructor.
     *
     * @param string $apiHost     Tripolis API host.
     * @param string $apiUsername Tripolis API username.
     * @param string $apiKey      Tripolis API key.
     * @param array  $httpOptions Http client options.
     */
    public function __construct($apiHost, $apiUsername, $apiKey, array $httpOptions = [])
    {
        $endpoint = $this->getApiEndpoint($apiHost);

        $config = array_merge([
            'base_uri' => $endpoint,
            'allow_redirects' => false,
            'auth' => [$apiUsername, $apiKey],
        ], $httpOptions);

        $this->httpClient = new HttpClient($config);
    }

    /**
     * Creates a Tripolis client.
     *
     * @param string $apiHost     Tripolis API host.
     * @param string $apiUsername Tripolis API username.
     * @param string $apiKey      Tripolis API key.
     * @param array  $httpOptions Http client options.
     *
     * @return Client
     */
    public static function create($apiHost, $apiUsername, $apiKey, array $httpOptions = [])
    {
        return new static($apiHost, $apiUsername, $apiKey, $httpOptions);
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
     * Gets Tripolis api endpoint.
     *
     * @param string $apiHost
     */
    protected function getApiEndpoint($apiHost)
    {
        // check data center
        if (preg_match('/^[0-9]{2}$/', $apiHost)) {
            $uri = sprintf('td%d.tripolis.com', $apiHost);
        } elseif (preg_match('/^td[0-9]{2}$/', $apiHost)) {
            $uri = sprintf('%s.tripolis.com', $apiHost);
        } else {
            $uri = $apiHost;
        }

        $components = parse_url($uri);
        if (!isset($components['scheme'])) {
            $uri = sprintf('https://%s', $uri);
        }
        if (!preg_match('/\/api3\/rest$/', $uri)) {
            $uri = sprintf('%s/api3/rest', $uri);
        }

        $uri = sprintf('%s/', rtrim($uri, '/'));
        if (!preg_match('/https:\/\/td[0-9]{2}\.tripolis\.com\/api3\/rest\/$/', $uri)) {
            throw new \UnexpectedValueException(sprintf("The uri '%s' is not valid.", $uri));
        }

        return $uri;
    }
}
