<?php

namespace Tripolis\Api\ContactDatabase;

use GuzzleHttp;
use Tripolis\Api\AbstractApi;

class BulkContact extends AbstractApi
{
    /**
     * Create contacts in one bulk operation.
     *
     * Create many new contacts with field values and optional group memberships.
     *
     * @param string $contactDatabaseId The contact database identifier.
     * @param array  $data              The bulk data.
     *
     * @return object
     */
    public function create($contactDatabaseId, array $data)
    {
        return $this->post(GuzzleHttp\uri_template('contactdatabases/{contactDatabaseId}/bulkcontacts', [
            'contactDatabaseId' => $contactDatabaseId,
        ]), [
            'json' => $data,
        ]);
    }
}
