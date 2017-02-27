<?php

namespace Tripolis\Tests\Api;

use Tripolis\Client;

abstract class AbstractApiTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns a new Client instance.
     *
     * @return Client
     */
    protected function getClient()
    {
        return new Client($_SERVER['TRIPOLIS_API_HOST'], $_SERVER['TRIPOLIS_API_USERNAME'], $_SERVER['TRIPOLIS_API_KEY']);
    }

    /**
     * Checks if the property exist in the given response.
     *
     * @param object $response
     * @param mixed  $expected
     */
    protected function assertPropertyExists($response, $expected)
    {
        $expected = (array) $expected;

        $count = count(get_object_vars($response));
        $this->assertCount($count, $expected, 'The number of expected properties does not match.');

        foreach ($expected as $property) {
            $this->assertTrue(property_exists($response, $property), sprintf('The property "%s" does not exits.', $property));
        }
    }
}
