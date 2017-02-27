<?php

namespace Tripolis\Api\ContactDatabase;

use GuzzleHttp;
use Tripolis\Api\AbstractApi;

class Subscription extends AbstractApi
{
    /**
     * Get contact subscription.
     *
     * Get subscription details of a contact with field values and contact group memberships,
     * including confirmation status.
     *
     * @param string $contactDatabaseId The contact database identifier.
     * @param string $contactId         The contact identifier.
     *
     * @return object
     */
    public function show($contactDatabaseId, $contactId)
    {
        return $this->get(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}/subscriptions/{contactId}', [
            'contactDatabaseId' => $contactDatabaseId,
            'contactId' => $contactId,
        ]));
    }

    /**
     * Create contact subscription.
     *
     * Create a new contact with field values and group memberships.
     * Optionally update an existing contact based on key field values by setting
     * updateExisting to true.
     *
     * @param string $contactDatabaseId The contact database identifier.
     * @param array  $data              The contact data.
     *
     * @return object
     */
    public function create($contactDatabaseId, array $data)
    {
        if (!isset($data['ipAddress'])) {
            $data += ['ipAddress' => $_SERVER['REMOTE_ADDR']];
        }

        return $this->post(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}/subscriptions', [
            'contactDatabaseId' => $contactDatabaseId,
        ]), [
            'json' => $data,
        ]);
    }

    /**
     * Update contact subscriptions.
     *
     * Update the subscription details like field values and contact group membership of a contact.
     * Can also be used to update the confirmed status in a group or to unsubscribe a contact from all groups.
     *
     * @param string $contactDatabaseId The contact database identifier.
     * @param string $contactId         The contact identifier.
     * @param array  $data              The contact data.
     *
     * @return object
     */
    public function update($contactDatabaseId, $contactId, array $data)
    {
        if (!isset($data['ipAddress'])) {
            $data += ['ipAddress' => $_SERVER['REMOTE_ADDR']];
        }

        return $this->patch(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}/subscriptions/{contactId}', [
            'contactDatabaseId' => $contactDatabaseId,
            'contactId' => $contactId,
        ]), [
            'json' => $data,
        ]);
    }
}
