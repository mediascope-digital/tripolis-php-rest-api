<?php

namespace Tripolis\Api;

use GuzzleHttp;

class ContactDatabase extends AbstractApi
{
    /**
     * Get list of contact databases.
     *
     * Get a list of available contact databases. List supports sorting and filtering.
     *
     * @param array $params An array of sorting and filtering parameters
     *
     * @return object
     */
    public function all(array $params = [])
    {
        return $this->get('contactdatabases', [
            'query' => $params,
        ]);
    }

    /**
     * Get a contact databases.
     *
     * Return a single contact database record.
     *
     * @param string $contactDatabaseId The contact database identifier.
     *
     * @return object
     */
    public function show($contactDatabaseId)
    {
        return $this->get(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}', [
            'contactDatabaseId' => $contactDatabaseId,
        ]));
    }

    /**
     * Returns a new BulkContact instance.
     *
     * @return BulkContact
     */
    public function bulkContact()
    {
        return new BulkContact($this);
    }

    /**
     * Returns a new Contact instance.
     *
     * @return Contact
     */
    public function contact()
    {
        return new Contact($this);
    }

    /**
     * Returns a new Subscription instance.
     *
     * @return Subscription
     */
    public function subscription()
    {
        return new Subscription($this);
    }
}
