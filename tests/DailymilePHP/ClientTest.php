<?php

class ClientTest extends PHPUnit_Framework_TestCase {

    private $_fetcher, $_client;

    public function setUp()
    {
        $fetch = array(
            array('entries', null, 'foo'),
            array('people/foo', null, 'people'),
            array('people/foo/friends', null, 'foo friends'),
            array('people/foo/routes', null, 'foo routes')
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
        $this->_client->getEntries(['username' => 'foo']);
    }

    public function testGetPersonFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo');
        $this->_client->getPerson(['username' => 'foo']);
    }

    public function testGetPersonReturnsResultOfFetch()
    {
        $this->assertEquals('people', $this->_client->getPerson(['username' => 'foo']));
    }

    public function testGetFriendsFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/friends');
        $this->_client->getFriends(['username' => 'foo']);
    }

    public function testGetFriendsReturnsResultOfFetch()
    {
        $this->assertEquals('foo friends', $this->_client->getFriends(['username' => 'foo']));
    }

    public function testGetRoutesFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/routes');
        $this->_client->getRoutes(['username' => 'foo']);
    }

    public function testGetRoutes()
    {
        $this->assertEquals('foo routes', $this->_client->getRoutes(['username' => 'foo']));
    }

    public function testGetEntryFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('entries/foo');
        $this->_client->getEntry(['id' => 'foo']);
    }

    public function testMissingMethodThrowsException(){
        $this->setExpectedException('BadMethodCallException');
        $this->_client->missingMethod();
    }

    public function testMissingIndexThrowsException()
    {
        $this->setExpectedException('BadMethodCallException');
        $this->_client->getMissingMethod(['foo']);
    }

    private function setFetchExpectation($fetchEndpoint)
    {
        $this->_fetcher = $this->getMock("DailymilePHP\\Fetcher");
        $this->_fetcher->expects($this->once())->method('fetch')->with($fetchEndpoint);
        $this->_client->setFetcher($this->_fetcher);
    }

}
