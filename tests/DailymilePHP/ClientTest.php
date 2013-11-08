<?php

class ClientTest extends PHPUnit_Framework_TestCase {

    private $_fetcher, $_client;

    public function setUp()
    {
        $fetch = array(
            array('entries', 'foo'),
            array('people/foo', 'people'),
            array('people/foo/friends', 'foo friends'),
            array('people/foo/routes', 'foo routes')
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

    public function testGetFriendsFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/friends');
        $this->_client->getFriends('foo');
    }

    public function testGetFriendsReturnsResultOfFetch()
    {
        $this->assertEquals('foo friends', $this->_client->getFriends('foo'));
    }

    public function testGetRoutesFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/routes');
        $this->_client->getRoutes('foo');
    }

    public function testGetRoutes()
    {
        $this->assertEquals('foo routes', $this->_client->getRoutes('foo'));
    }

    public function testMissingMethodThrowsException(){
        $this->setExpectedException('BadMethodCallException');
        $this->_client->missingMethod();
    }

    private function setFetchExpectation($fetchEndpoint)
    {
        $this->_fetcher = $this->getMock("DailymilePHP\\Fetcher");
        $this->_fetcher->expects($this->once())->method('fetch')->with($fetchEndpoint);
        $this->_client->setFetcher($this->_fetcher);
    }

}
