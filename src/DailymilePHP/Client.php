<?php

namespace DailymilePHP;

class Client {
    private $_fetcher;

    public function getEntries()
    {
        $this->getFetcher()->fetch('entries');
    }

    public function getFetcher()
    {
        return $this->_fetcher;
    }

    public function setFetcher($fetcher)
    {
        $this->_fetcher = $fetcher;
    }
}
