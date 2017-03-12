<?php

namespace Tripolis\Tests;

use Tripolis\Api;
use Tripolis\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Client::create
     */
    public function testCreate()
    {
        $client = Client::create('https://tdXX.tripolis.com', null, null);

        $this->assertInstanceOf(Client::class, $client);
    }

    /**
     * @covers Client::setApiUrl
     *
     * @dataProvider getSetUrlProvider
     */
    public function testSetUrl($url, $expected)
    {
        $client = Client::create($url, null, null);

        $this->assertEquals($expected, $client->getApiUrl());
    }

    /**
     * @return array
     */
    public function getSetUrlProvider()
    {
        return [
            ['https://tdXX.tripolis.com', 'https://tdXX.tripolis.com/api3/rest/'],
            ['https://tdXX.tripolis.com/', 'https://tdXX.tripolis.com/api3/rest/'],
            ['https://tdXX.tripolis.com/api3/rest', 'https://tdXX.tripolis.com/api3/rest/'],
            ['https://tdXX.tripolis.com/api3/rest/', 'https://tdXX.tripolis.com/api3/rest/'],
        ];
    }

    /**
     * @covers Client::api
     *
     * @dataProvider getApiClassesProvider
     */
    public function testApi($apiName, $class)
    {
        $client = new Client('https://tdXX.tripolis.com', null, null);

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @covers Client::__call
     *
     * @dataProvider getApiClassesProvider
     */
    public function testMagicApi($apiName, $class)
    {
        $client = new Client('https://tdXX.tripolis.com', null, null);

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @return array
     */
    public function getApiClassesProvider()
    {
        return [
            ['contactDatabase', Api\ContactDatabase::class],
            ['contactdatabase', Api\ContactDatabase::class],
            ['contactDatabases', Api\ContactDatabase::class],
            ['contactdatabases', Api\ContactDatabase::class],
        ];
    }

    /**
     * @covers Client::api
     *
     * @expectedException \InvalidArgumentException
     */
    public function testNotApi()
    {
        $client = new Client('https://tdXX.tripolis.com', null, null);
        $client->api('noApiCall');
    }

    /**
     * @covers Client::__call
     *
     * @expectedException \BadMethodCallException
     */
    public function testNotMagicApi()
    {
        $client = new Client('https://tdXX.tripolis.com', null, null);
        $client->noApiCall();
    }
}
