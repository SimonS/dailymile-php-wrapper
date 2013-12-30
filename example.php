<?php

require 'vendor/autoload.php';

$client = new DailymilePHP\Client;

// Get latest public entries
var_dump($client->getEntries(['page' => '2']));

// Get latest nearby entries
var_dump($client->getNearby(['latitude' => '37.77916', 'longitude' => '-122.420049']));

// Get latest entries of specific unprotected username
var_dump($client->getEntries(['username' => 'simons']));

//Get individual entry
var_dump($client->getEntry(['id' => '22399']));

// Get person
var_dump($client->getPerson(['username' => 'simons']));

// Get person's friends
var_dump($client->getFriends(['username' => 'simons']));

// Get person's routes
var_dump($client->getRoutes(['username' => 'simons']));

// Get all entries
var_dump($client->getEntries(['username' => 'simons', 'page' => 'all', 'since' => '1325462400', 'until' => '1330387200']));
