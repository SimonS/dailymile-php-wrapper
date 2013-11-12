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
        $parameter = count($params) ? $params[0] : null;
        $methodMap = array(
            "person" => "people/$parameter",
            "entries" => "people/$parameter/entries",
            "friends" => "people/$parameter/friends",
            "routes" => "people/$parameter/routes",
            "entry" => "entries/$parameter"
        );

        if (isset($methodMap[$method]))
        {
            return $this->getFetcher()->fetch($methodMap[$method]);
        }

        throw new \BadMethodCallException;
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
