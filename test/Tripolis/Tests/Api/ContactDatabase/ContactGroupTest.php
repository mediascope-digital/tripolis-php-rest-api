<?php

namespace Tripolis\Tests\Api\ContactDatabase;

use Tripolis\Api\ContactDatabase\ContactGroup;
use Tripolis\Tests\Api\AbstractApiTestCase;

class ContactGroupTest extends AbstractApiTestCase
{
    /**
     * @covers ContactGroup::all
     */
    public function testAll()
    {
        $api = new ContactGroup($this->getClient());
        $response = $api->all($this->getContactDatabaseId());

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('contactGroups', $response);
        $this->assertInternalType('array', $response->contactGroups);
    }

    /**
     * @covers ContactGroup::all
     */
    public function testAllFilterByName()
    {
        $contactGroupName = $this->getContactGroupSubscribersName();

        $api = new ContactGroup($this->getClient());
        $response = $api->all($this->getContactDatabaseId(), [
            'name' => $contactGroupName,
        ]);

        $this->assertGreaterThanOrEqual(1, $response->contactGroups);
    }
}
