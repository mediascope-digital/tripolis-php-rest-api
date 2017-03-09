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
        $client = Client::create($_SERVER['TRIPOLIS_API_DATACENTER'], $_SERVER['TRIPOLIS_API_USERNAME'], $_SERVER['TRIPOLIS_API_KEY']);

        $this->assertInstanceOf(Client::class, $client);
    }
}
