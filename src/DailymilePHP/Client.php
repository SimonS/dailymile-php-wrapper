<?php

namespace DailymilePHP;

class Client {
    private $_fetcher;

    public function getEntries(array $parameters=null)
    {
        return $parameters 
            ? $this->fetchFromMap('entries', func_get_args()) 
            : $this->getFetcher()->fetch("entries");
    }


    public function __call($method, array $args)
    {
        preg_match('/^get([A-Z].*)/', $method, $matches);
        if (isset($matches[1]))
        {
            return $this->fetchFromMap(mb_strtolower($matches[1]), $args);
        }
        throw new \BadMethodCallException;
    }

    private function fetchFromMap($method, array $params)
    {
        $username = null;
        $id = null;

        $parameters = count($params) ? $params[0] : null;
        extract($parameters, EXTR_IF_EXISTS);

        $methodMap = array(
            "person" => "people/$username",
            "entries" => "people/$username/entries",
            "friends" => "people/$username/friends",
            "routes" => "people/$username/routes",
            "entry" => "entries/$id"
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

    public function setFetcher(Fetcher $fetcher)
    {
        $this->_fetcher = $fetcher;
    }
}
