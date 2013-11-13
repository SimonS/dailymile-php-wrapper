<?php

namespace DailymilePHP;

class Fetcher {

    private $_httpClient;

    public function __construct($httpClient=null)
    {
        $this->_httpClient = $httpClient ?: new \Guzzle\Http\Client;
    }

    public function fetch($endpoint='', $params=null)
    {
        $url = "http://api.dailymile.com/$endpoint.json";

        $url = $params 
            ? "$url?" . $this->appendParameters($params) 
            : $url;
        
        $response = $this->_httpClient->get($url)->send()->getBody();
        return json_decode($response);
    }

    private function appendParameters($params)
    {
        array_walk($params, function(&$value, $key) {
            $value = "$key=" . urlencode($value);
        }); 

        return implode('&', $params);
    }
}
