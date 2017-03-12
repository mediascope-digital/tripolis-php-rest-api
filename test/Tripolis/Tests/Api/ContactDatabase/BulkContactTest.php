<?php

namespace Tripolis\Tests\Api\ContactDatabase;

use Tripolis\Api\ContactDatabase;
use Tripolis\Api\ContactDatabase\BulkContact;
use Tripolis\Api\ContactDatabase\Contact;
use Tripolis\Api\ContactDatabase\ContactGroup;
use Tripolis\Tests\Api\AbstractApiTestCase;

class BulkContactTest extends AbstractApiTestCase
{
    /**
     * @covers BulkContact::create
     *
     * @dataProvider getCreateContactsProvider
     */
    public function testCreate($emails)
    {
        $contactGroupApi = new ContactGroup($this->getClient());
        $contactGroupSubscribersName = $this->getContactGroupSubscribersName();

        $response = $contactGroupApi->all($this->getContactDatabaseId(), [
            'name' => $contactGroupSubscribersName,
        ]);

        foreach ($response->contactGroups as $contactGroup) {
            if ($contactGroup->name === $contactGroupSubscribersName) {
                break;
            }
        }

        $contactsFields = [];
        foreach ($emails as $email) {
            $contactsFields[] = [
                'contactFields' => ['email' => $email],
            ];
        }

        $api = new BulkContact($this->getClient());
        $response = $api->create($this->getContactDatabaseId(), [
            'contactsWithFieldValues' => $contactsFields,
            'contactGroupSubscriptions' => [
                [
                    'contactGroupId' => $contactGroup->id,
                    'confirmed' => false,
                ],
            ],
            'returnFields' => [
                'email',
            ],
        ]);

        $this->assertInstanceOf('stdClass', $response);
        $this->assertPropertyExists('createdContacts', $response);
        $this->assertCount(count($contactsFields), $response->createdContacts);
        $this->assertPropertyExists('bulkContactErrors', $response);
        $this->assertEmpty($response->bulkContactErrors);
    }

    /**
     * @return array
     */
    public function getCreateContactsProvider()
    {
        $emails = [];
        $i = 0;

        while ($i <= 1) {
            $emails[] = sprintf('%s@tripolis.com', uniqid());
            $i++;
        }

        return [[$emails]];
    }
}
