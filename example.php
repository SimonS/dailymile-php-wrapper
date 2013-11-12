<?php

require 'vendor/autoload.php';

$client = new DailymilePHP\Client;

// Get latest public entries
var_dump($client->getEntries());

// Get latest entries of specific unprotected username
var_dump($client->getEntries('simons'));

//Get individual entry
var_dump($client->getEntry('22399'));

// Get person
var_dump($client->getPerson('simons'));

// Get person's friends
var_dump($client->getFriends('simons'));

// Get person's routes
var_dump($client->getRoutes('simons'));
