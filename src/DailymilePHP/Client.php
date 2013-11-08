<?php

namespace DailymilePHP;

class Client {
    private $_fetcher;

    public function getEntries($username=null)
    {
        $endpoint = "entries";

        if ($username)
        {
            $endpoint = "people/$username/$endpoint";
        }

        return $this->getFetcher()->fetch($endpoint);
    }

    public function getPerson($username)
    {
        return $this->getFetcher()->fetch("people/$username");
    }

    public function getFetcher()
    {
        if (!$this->_fetcher)
        {
            $this->_fetcher = new Fetcher;
        }

        return $this->_fetcher;
    }

    public function setFetcher($fetcher)
    {
        $this->_fetcher = $fetcher;
    }
}
