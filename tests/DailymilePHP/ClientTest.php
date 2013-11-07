<?php

class ClientTest extends PHPUnit_Framework_TestCase {

    public function testGetEntriesTriesToFetchEntries()
    {
        $mockFetcher = $this->getMockBuilder("DailymilePHP\\Fetcher")
            ->getMock();
        $mockFetcher->expects($this->once())->method('fetch')->with('entries');

        $client = new \DailymilePHP\Client;
        $client->setFetcher($mockFetcher);

        $client->getEntries();
    }
}
