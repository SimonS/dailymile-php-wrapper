<?php

namespace DailymilePHP;

class Client {
    private $_fetcher;

    public function getEntries($parameters=array())
    {
        if (!is_array($parameters))
            $parameters = ['username' => $parameters];

        if (!isset($parameters['username']))
            return $this->getFetcher()->fetch(
                "entries", 
                $this->whitelistParameters($parameters)
            );

        return $this->normaliseAndFetch($parameters, "entries");
    }

    public function getFriends($username)
    {
        $username = $this->normaliseParameter($username);
        return $this->getFetcher()->fetch("people/$username/friends");
    }

    public function getRoutes($username)
    {
        $username = $this->normaliseParameter($username);
        return $this->getFetcher()->fetch("people/$username/routes");
    }
    
    public function getEntry($id)
    {
        $id = $this->normaliseParameter($id, 'id');
        return $this->getFetcher()->fetch("entries/$id");
    }

    public function getPerson($username)
    {
        $username = $this->normaliseParameter($username);
        return $this->getFetcher()->fetch("people/$username");
    }

    private function whitelistParameters($parameters)
    {
        return array_intersect_key($parameters, array_flip(
            ['until', 'since', 'page']
        ));
    }

    private function normaliseAndFetch($parameters, $end)
    {
        $username = $this->normaliseParameter($parameters);
        $parameters = !is_array($parameters) ? [] : $parameters;

        return $this->getFetcher()->fetch(
            "people/$username/$end", 
            $this->whitelistParameters($parameters)
        );
    }

    private function normaliseParameter($param, $key='username')
    {
        return is_array($param) ? $param[$key] : $param;
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
