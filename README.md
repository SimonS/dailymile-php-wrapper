dailymile-php-wrapper [![Build Status](https://travis-ci.org/SimonS/dailymile-php-wrapper.png?branch=master)](https://travis-ci.org/SimonS/dailymile-php-wrapper)
=====================

Simple wrapper around the Dailymile API

## Usage:

```php
$client = new DailymilePHP\Client;

// Get entries:
$client->getEntries(['page' => '2']);

// Get latest nearby entries
$client->getNearby(['latitude' => '37.77916', 'longitude' => '-122.420049']);

// Get latest entries of specific unprotected username
$client->getEntries(['username' => 'simons']);

// Get all entries between specified times
$client->getEntries(['username' => 'simons', 'since' => '1325462400', 'until' => '1330387200', 'page' => 'all']);

//Get individual entry
$client->getEntry(['id' => '22399']);

// Get person
$client->getPerson(['username' => 'simons']);

// Get person's friends
$client->getFriends(['username' => 'simons']);

// Get person's routes
$client->getRoutes(['username' => 'simons']);

```
