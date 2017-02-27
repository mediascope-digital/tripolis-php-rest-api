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

        $this->assertInternalType('array', $response);
        $this->assertPropertyExists($response[0], [
            'id',
            'label',
            'name',
            'properties',
            'defaultContactDatabaseFieldName',
            'defaultContactDatabaseFieldGroupId',
            'modifiedAt',
        ]);
    }

    /**
     * @covers ContactDatabase::show
     */
    public function testShow()
    {
        $api = new ContactDatabase($this->getClient());

        $contactDatabase = current($api->all());

        $response = $api->show($contactDatabase->id);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists($response, [
            'id',
            'label',
            'name',
            'properties',
            'defaultContactDatabaseFieldName',
            'defaultContactDatabaseFieldGroupId',
            'modifiedAt',
        ]);
    }
}
