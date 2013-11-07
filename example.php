<?php

require 'vendor/autoload.php';

$client = new DailymilePHP\Client;

// Get latest public entries
var_dump($client->getEntries());

// Get latest entries of specific unprotected username
var_dump($client->getEntries('simons'));
