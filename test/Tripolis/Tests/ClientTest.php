<?php

namespace Tripolis\Tests;

use Tripolis\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Client::create
     */
    public function testCreate()
    {
        $client = Client::create($_SERVER['TRIPOLIS_API_HOST'], $_SERVER['TRIPOLIS_API_USERNAME'], $_SERVER['TRIPOLIS_API_KEY']);

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @covers Client::setApiEndpoint
     *
     * @dataProvider getSetApiEndpointData
     */
    public function testSetApiEndpoint($actual, $expected)
    {
        $client = new Client($actual, null, null);

        // $this->assertAttributeEquals($expected, 'apiEndpoint', $client);
    }

    /**
     * @return array
     */
    public function getSetApiEndpointData()
    {
        return [
            ['52', 'https://td52.tripolis.com/api3/rest/'],
            ['td52', 'https://td52.tripolis.com/api3/rest/'],
            ['https://td52.tripolis.com', 'https://td52.tripolis.com/api3/rest/'],
            ['https://td52.tripolis.com/api3/rest', 'https://td52.tripolis.com/api3/rest/'],
        ];
    }

    /**
     * @covers Client::setApiEndpoint
     *
     * @expectedException \UnexpectedValueException
     */
    public function testExceptionSetApiEndpoint()
    {
        $client = new Client('foo', null, null);
    }
}
