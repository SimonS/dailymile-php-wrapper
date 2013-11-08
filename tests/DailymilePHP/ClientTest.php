<?php

class ClientTest extends PHPUnit_Framework_TestCase {

    private $_fetcher, $_client;

    public function setUp()
    {
        $fetch = array(
            array('entries', 'foo'),
            array('people/foo', 'people')
        );

        $this->_fetcher = $this->getMock("DailymilePHP\\Fetcher");
        $this->_fetcher->expects($this->any())->method('fetch')->will($this->returnValueMap($fetch));

        $this->_client = new \DailymilePHP\Client;
        $this->_client->setFetcher($this->_fetcher);
    }

    public function testGetEntriesTriesToFetchEntries()
    {
        $this->setFetchExpectation('entries');
        $this->_client->getEntries();
    }

    public function testGetEntriesReturnsResultOfFetch()
    {
        $this->assertEquals('foo', $this->_client->getEntries());
    }

    public function testGetEntriesWithUsernameUsesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/entries');
        $this->_client->getEntries('foo');
    }

    public function testGetPersonFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo');
        $this->_client->getPerson('foo');
    }

    public function testGetPersonReturnsResultOfFetch()
    {
        $this->assertEquals('people', $this->_client->getPerson('foo'));
    }

    private function setFetchExpectation($fetchEndpoint)
    {
        $this->_fetcher = $this->getMock("DailymilePHP\\Fetcher");
        $this->_fetcher->expects($this->once())->method('fetch')->with($fetchEndpoint);
        $this->_client->setFetcher($this->_fetcher);
    }

}
