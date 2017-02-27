<?php

namespace Tripolis\Api\ContactDatabase;

use GuzzleHttp;
use Tripolis\Api\AbstractApi;

class Contact extends AbstractApi
{
    /**
     * Delete a contact record completely from the database.
     *
     * @param string $contactDatabaseId The contact database identifier.
     * @param string $contactId         The contact identifier.
     *
     * @return object
     */
    public function remove($contactDatabaseId, $contactId)
    {
        return $this->delete(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}/contacts/{contactId}', [
            'contactDatabaseId' => $contactDatabaseId,
            'contactId' => $contactId,
        ]));
    }
}
