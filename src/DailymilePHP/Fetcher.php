<?php

namespace DailymilePHP;

class Fetcher {

    private $_httpClient;

    public function __construct($httpClient=null)
    {
        $this->_httpClient = $httpClient ?: new \Guzzle\Http\Client;
    }

    public function fetch($endpoint='')
    {
        $url = "http://api.dailymile.com/$endpoint.json";
        $response = $this->_httpClient->get($url)->send()->getBody();
        return json_decode($response);
    }
}
