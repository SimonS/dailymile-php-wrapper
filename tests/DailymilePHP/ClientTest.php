<?php

class ClientTest extends PHPUnit_Framework_TestCase {

    private $_fetcher, $_client;

    public function setUp()
    {
        $this->_fetcher = $this->getMockBuilder("DailymilePHP\\Fetcher")
            ->getMock();

        $this->_fetcher->expects($this->any())->method('fetch')->with('entries')
            ->will($this->returnValue(json_decode('{}')));

        $this->_client = new \DailymilePHP\Client;
        $this->_client->setFetcher($this->_fetcher);
    }

    public function testGetEntriesTriesToFetchEntries()
    {
        $this->setEntryExpectationAndGetEntries(null, 'entries');
    }

    public function testGetEntriesReturnsJsonObject()
    {
        $this->assertInstanceOf('stdClass', $this->_client->getEntries());
    }

    public function testGetEntriesWithUsernameUsesCorrectEndpoint()
    {
        $this->setEntryExpectationAndGetEntries('foo', 'people/foo/entries');
    }

    private function setEntryExpectationAndGetEntries($entryInput, $fetchEndpoint)
    {
        $this->_fetcher = $this->getMockBuilder("DailymilePHP\\Fetcher")
            ->getMock();
        $this->_fetcher->expects($this->once())->method('fetch')->with($fetchEndpoint);
        $this->_client->setFetcher($this->_fetcher);
        $this->_client->getEntries($entryInput);
    }

}
