<?php

namespace Tripolis;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use Tripolis\Api;
use Tripolis\Api\ApiInterface;

class Client
{
    /**
     * Tripolis API version.
     */
    const API_VARSION = '1.0';

    /**
     * Tripolis API url.
     *
     * @var string
     */
    private $apiUrl;

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
     * Http client.
     *
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * Constructor.
     *
     * @param string $apiUrl      Tripolis API url.
     * @param string $apiUsername Tripolis API username.
     * @param string $apiKey      Tripolis API key.
     * @param array  $httpOptions Http client options.
     */
    public function __construct($apiUrl, $apiUsername, $apiKey, array $httpOptions = [])
    {
        $this->setApiUrl($apiUrl);
        $this->apiUsername = $apiUsername;
        $this->apiKey = $apiKey;

        $config = array_merge([
            'base_uri' => $this->apiUrl,
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
     * @param string $apiUrl      Tripolis API url.
     * @param string $apiUsername Tripolis API username.
     * @param string $apiKey      Tripolis API key.
     * @param array  $httpOptions Http client options.
     *
     * @return Client
     */
    public static function create($apiUrl, $apiUsername, $apiKey, array $httpOptions = [])
    {
        return new static($apiUrl, $apiUsername, $apiKey, $httpOptions);
    }

    /**
     * Retruns the API url.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
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
     * @TODO
     *
     * @param string $name [description]
     *
     * @throws \InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($name)
    {
        switch ($name) {
            case 'contactDatabase':
            case 'contactdatabase':
            case 'contactDatabases':
            case 'contactdatabases':
                $api = new Api\ContactDatabase($this);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * @TODO
     *
     * @param string $name [description]
     *
     * @throws \BadMethodCallException
     *
     * @return ApiInterface
     */
    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (\InvalidArgumentException $e) {
            throw new \BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
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
     * Sets the API url.
     *
     * @param string $url
     */
    private function setApiUrl($url)
    {
        $url = filter_var($url, FILTER_VALIDATE_URL);
        if (!$url) {
            throw new \InvalidArgumentException('API URL should be a valid url');
        }

        $url = rtrim($url, '\\/');
        if (!preg_match('/api3\/rest$/', $url)) {
            $url = sprintf('%s/api3/rest', $url);
        }
        $url = sprintf('%s/', $url);

        $this->apiUrl = $url;
    }
}
