<?php

namespace Tripolis\Tests\Api\ContactDatabase;

use Tripolis\Api\ContactDatabase;
use Tripolis\Api\ContactDatabase\Contact;
use Tripolis\Api\ContactDatabase\Subscription;
use Tripolis\Tests\Api\AbstractApiTestCase;

class SubscriptionTest extends AbstractApiTestCase
{
    /**
     * @covers Subscription::create
     * @covers Subscription::show
     * @covers Subscription::update
     * @covers Contact::remove
     */
    public function testAll()
    {
        $api = new Subscription($this->getClient());
        $contactDatabaseId = $this->getContactDatabaseId();

        // new test email
        $newEmail = sprintf('%s@tripolis.com', uniqid());

        // create
        $response = $api->create($contactDatabaseId, [
            'contactFields' => [
                'email' => $newEmail,
            ],
            'ipAddress' => '127.0.0.1',
        ]);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('contactId', $response);

        $contactId = $response->contactId;

        // show
        $response = $api->show($contactDatabaseId, $contactId);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('contactFields', $response);
        $this->assertEquals($newEmail, $response->contactFields->email);

        // update test email
        $updateEmail = sprintf('%s@tripolis.com', uniqid());

        // update
        $response = $api->update($contactDatabaseId, $contactId, [
            'contactFields' => [
                'email' => $updateEmail,
            ],
            'ipAddress' => '127.0.0.1',
        ]);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('contactId', $response);

        // show
        $response = $api->show($contactDatabaseId, $contactId);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('contactFields', $response);
        $this->assertEquals($updateEmail, $response->contactFields->email);

        // remove
        $contactApi = new Contact($this->getClient());
        $response = $contactApi->remove($contactDatabaseId, $contactId);
        $this->assertEquals('', $response);
    }
}
