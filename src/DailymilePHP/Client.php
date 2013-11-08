<?php

namespace DailymilePHP;

class Client {
    private $_fetcher;

    public function getEntries($username=null)
    {
        return $username 
            ? $this->fetchFromMap('entries', func_get_args()) 
            : $this->getFetcher()->fetch("entries");
    }

    public function __call($method, $args)
    {
        preg_match('/^get([A-Z].*)/', $method, $matches);
        if (isset($matches[1]))
        {
            return $this->fetchFromMap(mb_strtolower($matches[1]), $args);
        }
        throw new \BadMethodCallException;
    }

    private function fetchFromMap($method, $params)
    {
        $username = $params[0];
        $methodMap = array(
            "person" => "people/$username",
            "entries" => "people/$username/entries",
            "friends" => "people/$username/friends",
            "routes" => "people/$username/routes"
        );

        return $this->getFetcher()->fetch($methodMap[$method]);
    }

    public function getFetcher()
    {
        $this->_fetcher = $this->_fetcher ?: new Fetcher;
        return $this->_fetcher;
    }

    public function setFetcher($fetcher)
    {
        $this->_fetcher = $fetcher;
    }
}
