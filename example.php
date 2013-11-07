<?php

require 'vendor/autoload.php';

$client = new DailymilePHP\Client;

var_dump($client->getEntries('simons'));
