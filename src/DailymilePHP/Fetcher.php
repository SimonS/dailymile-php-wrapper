<?php

namespace DailymilePHP;

class Fetcher {

    private $_httpClient;

    public function __construct($httpClient=null)
    {
        $this->_httpClient = $httpClient ?: new \Guzzle\Http\Client;
    }

    public function fetch()
    {
        $response = $this->_httpClient->get('http://api.dailymile.com/')->send()->getBody();
        return json_decode($response);
    }
}
