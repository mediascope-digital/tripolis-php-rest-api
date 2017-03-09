<?php

namespace Tripolis\Tests\Api;

use Tripolis\Api\ContactDatabase;
use Tripolis\Client;

class ContactDatabaseTest extends AbstractApiTestCase
{
    /**
     * @covers ContactDatabase::all
     */
    public function testAll()
    {
        $api = new ContactDatabase($this->getClient());
        $response = $api->all();

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('contactDatabases', $response);
        $this->assertInternalType('array', $response->contactDatabases);
    }

    /**
     * @covers ContactDatabase::all
     */
    public function testAllFilterByLabel()
    {
        $api = new ContactDatabase($this->getClient());
        $label = $api->show($this->getContactDatabaseId())->label;
        $response = $api->all(['label' => $label]);

        $this->assertCount(1, $response->contactDatabases);
    }

    /**
     * @covers ContactDatabase::all
     */
    public function testAllFilterByName()
    {
        $api = new ContactDatabase($this->getClient());
        $name = $api->show($this->getContactDatabaseId())->name;
        $response = $api->all(['name' => $name]);

        $this->assertCount(1, $response->contactDatabases);
    }

    /**
     * @covers ContactDatabase::show
     */
    public function testShow()
    {
        $api = new ContactDatabase($this->getClient());
        $response = $api->show($this->getContactDatabaseId());

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('id', $response);
    }
}
