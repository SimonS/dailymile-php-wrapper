<?php

namespace DailymilePHP;

class Client {
    private $_fetcher;

    public function getEntries($parameters=array())
    {
        if (!is_array($parameters))
            $parameters = ['username' => $parameters];

        if (!isset($parameters['username']))
        {
            if (isset($parameters['page']) && $parameters['page'] === 'all') 
            {
                throw new \InvalidArgumentException('All pages requires a username');
            }

            return $this->getFetcher()->fetch(
                "entries", 
                $this->whitelistParameters($parameters)
            )["entries"];
        }

        $result = $this->normaliseAndFetch($parameters, "entries");
        return $result['entries'];
    }

    public function getFriends($username)
    {
        $username = $this->normaliseParameter($username);
        return $this->getFetcher()->fetch("people/$username/friends")["friends"];
    }

    public function getRoutes($username)
    {
        $username = $this->normaliseParameter($username);
        return $this->getFetcher()->fetch("people/$username/routes")['routes'];
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

    public function getNearby($parameters)
    {
        $latitude = $parameters['latitude'];
        $longitude = $parameters['longitude'];
        $parameters = $this->whitelistParameters($parameters, ['radius']);

        return $this->getFetcher()->fetch(
            "entries/nearby/$latitude,$longitude", 
            $parameters
        )['entries'];
    }

    private function whitelistParameters($parameters, $extra=[])
    {
        return array_intersect_key($parameters, array_flip(
            array_merge(['until', 'since', 'page'], $extra)
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
