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
        // new test email
        $newEmail = sprintf('%s@tripolis.com', uniqid());

        $contactDatabaseApi = new ContactDatabase($this->getClient());
        $contactApi = new Contact($this->getClient());

        $contactDatabase = current($contactDatabaseApi->all());

        $api = new Subscription($this->getClient());

        // create
        $response = $api->create($contactDatabase->id, [
            'contactFields' => [
                'email' => $newEmail,
            ],
            'ipAddress' => '127.0.0.1',
        ]);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists($response, ['contactId']);

        $contactId = $response->contactId;

        // show
        $response = $api->show($contactDatabase->id, $contactId);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists($response, [
            'contactFields',
        ]);
        $this->assertEquals($newEmail, $response->contactFields->email);

        // update test email
        $updateEmail = sprintf('%s@tripolis.com', uniqid());

        // update
        $response = $api->update($contactDatabase->id, $contactId, [
            'contactFields' => [
                'email' => $updateEmail,
            ],
            'ipAddress' => '127.0.0.1',
        ]);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists($response, ['contactId']);

        // show
        $response = $api->show($contactDatabase->id, $contactId);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists($response, [
            'contactFields',
        ]);
        $this->assertEquals($updateEmail, $response->contactFields->email);

        // remove
        $response = $contactApi->remove($contactDatabase->id, $contactId);
        $this->assertEquals('', $response);
    }
}
