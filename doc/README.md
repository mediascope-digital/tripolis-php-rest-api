APIs
==========

## Contact Databases

##### List all contact databases.

```
$contactDatabases = $tripolis->api('contactDatabases')->all();
```

Also you can filter by `sort`, `label` or `name`:

```
$contactDatabases = $tripolis->api('contactDatabases')->all([
	'label' => 'My database label',
	...
]);
```

##### Get a contact databases.

```
$contactDatabases = $tripolis->api('contactDatabases')->show('N5rfmC0jnlj4pSzPRc5NMw');
```

### Subscriptions

##### Get a contact subscription.

```
$subscription = $tripolis->api('contactDatabases')->subscription()->show('N5rfmC0jnlj4pSzPRc5NMw', 'D4Vvp1V7aMx3rVKSUzHUmg');
```

##### Create a contact subscription.

```
$subscription = $tripolis->api('contactDatabases')->subscription()->create('N5rfmC0jnlj4pSzPRc5NMw', [
	'contactFields' => [
		'email' => 'email@tripolis.com',
		...
	],
	...
]);
```

##### Update a contact subscription.

```
$subscription = $tripolis->api('contactDatabases')->subscription()->update('N5rfmC0jnlj4pSzPRc5NMw', 'D4Vvp1V7aMx3rVKSUzHUmg', [
	'contactFields' => [
		'email' => 'updatedemail@tripolis.com',
		...
	],
	...
]);
```

### Contacts

Delete a contact record completely from the database.

```
$response = $tripolis->api('contactDatabases')->contact()->remove('N5rfmC0jnlj4pSzPRc5NMw', 'D4Vvp1V7aMx3rVKSUzHUmg');
```

### Bulk contacts

Create contacts in one bulk operation.

```
$response = $tripolis->api('contactDatabases')->bulkContact()->create('N5rfmC0jnlj4pSzPRc5NMw', [
	'contactsWithFieldValues' => [
		[
			'contactFields' => [
				'email' => 'email1@tripolis.com',
				...
			]
		],
		[
			'contactFields' => [
				'email' => 'email2@tripolis.com',
				...
			]
		],
		...
 	],
 	'contactGroupSubscriptions' => [
 		[
 			'contactGroupId' => 'HTWJKQHtqAcY4HuG0quzng', // Required
 			'confirmed' => true, // Required
 		],
 		[
 			'contactGroupId' => 'HTWJKQHtqAcY4HuG0quzng', // Required
 			'confirmed' => false, // Required
 		],
 		...
 	],
 	'reference' => 'myAwesomeBulk', // Not required
 	'returnFields' => [ // At least one field ir required
 		'email', ...
 	],
]);
```
