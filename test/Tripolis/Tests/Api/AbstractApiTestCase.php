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
        return new Client($_SERVER['TRIPOLIS_API_URL'], $_SERVER['TRIPOLIS_API_USERNAME'], $_SERVER['TRIPOLIS_API_KEY']);
    }

    /**
     * Returns contact database for testing purpose.
     *
     * @return string
     */
    protected function getContactDatabaseId()
    {
        return $_SERVER['TRIPOLIS_CONTACT_DATABASE_ID'];
    }

    /**
     * Returns contact group subscribers name for testing purpose.
     *
     * @return string
     */
    protected function getContactGroupSubscribersName()
    {
        return $_SERVER['TRIPOLIS_CONTACT_GROUP_SUBSCRIBERS_NAME'];
    }

    /**
     * Returns contact group unsubscribers name for testing purpose.
     *
     * @return string
     */
    protected function getContactGroupUnsubscribersName()
    {
        return $_SERVER['TRIPOLIS_CONTACT_GROUP_UNSUBSCRIBERS_NAME'];
    }

    /**
     * Checks if the property exist in the given response.
     *
     * @param string    $property The property name
     * @param \stdClass $response The response
     */
    protected function assertPropertyExists($property, \stdClass $response)
    {
        $this->assertTrue(property_exists($response, $property), sprintf('The property "%s" does not exits.', $property));
    }
}
