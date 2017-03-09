<?php

namespace Tripolis\Api\ContactDatabase;

use GuzzleHttp;
use Tripolis\Api\AbstractApi;

class ContactGroup extends AbstractApi
{
    /**
     * Get list of contact groups.
     *
     * Get a list of available contact groups in contact databases. List supports paging, sorting and filtering.
     *
     * @param string $contactDatabaseId The contact database identifier.
     * @param array  $params            An array of sorting and filtering parameters
     *
     * @return object
     */
    public function all($contactDatabaseId, array $params = [])
    {
        return $this->get(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}/contactgroups', [
            'contactDatabaseId' => $contactDatabaseId,
        ]), [
            'query' => $params,
        ]);
    }
}
