<?php

class ClientTest extends PHPUnit_Framework_TestCase {

    private $_fetcher, $_client;

    public function setUp()
    {
        $fetch = array(
            array('entries', [], ['entries' => [1,2]]),
            array('people/foo/entries', [], ['entries' => [1,2]]),
            array('entries/nearby/lat,lon', [], ['entries' => [3,4]]),
            array('people/foo', [], 'people'),
            array('people/foo/friends', [], ['friends' => [5,6]]),
            array('people/foo/routes', [], ['routes' => [7,8]])
        );

        $this->_fetcher = $this->getMock("DailymilePHP\\Fetcher");
        $this->_fetcher->expects($this->any())->method('fetch')->will(
            $this->returnValueMap($fetch)
        );

        $this->_client = new \DailymilePHP\Client;
        $this->_client->setFetcher($this->_fetcher);
    }

    public function testGetEntriesTriesToFetchEntries()
    {
        $this->setFetchExpectation('entries');
        $this->_client->getEntries();
    }

    public function testGetEntriesCanPageResults()
    {
        $this->setFetchExpectation('entries', ['page' => '3']);
        $this->_client->getEntries(['page' => '3']);
    }

    public function testGetEntriesWhitelistsParameters()
    {
        $this->setFetchExpectation('entries', ['until' => '2']);
        $this->_client->getEntries(['foo' => '3', 'until' => '2']);
        $this->setFetchExpectation('people/fred/entries', ['until' => '2']);
        $this->_client->getEntries(
            ['username' => 'fred', 'foo' => '3', 'until' => '2']
        );
    }

    public function testGetEntriesReturnsResultOfFetch()
    {
        $this->assertEquals([1,2], $this->_client->getEntries());
        $this->assertEquals([1,2], $this->_client->getEntries('foo'));
    }

    public function testGetEntriesWithUsernameUsesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/entries');
        $this->_client->getEntries(['username' => 'foo']);
        $this->setFetchExpectation('people/foo/entries');
        $this->_client->getEntries('foo');
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
        $this->setFetchExpectation('people/foo/friends');
        $this->_client->getFriends('foo');
    }
    
    public function testGetFriendsReturnsResultOfFetch()
    {
        $this->assertEquals(
            [5,6], 
            $this->_client->getFriends(['username' => 'foo'])
        );
    }

    public function testGetRoutesFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('people/foo/routes');
        $this->_client->getRoutes(['username' => 'foo']);
        $this->setFetchExpectation('people/foo/routes');
        $this->_client->getRoutes('foo');
    }

    public function testGetRoutes()
    {
        $this->assertEquals([7,8], $this->_client->getRoutes(['username' => 'foo']));
    }

    public function testGetNearby()
    {
        $this->setFetchExpectation('entries/nearby/1,2');
        $this->_client->getNearby(['latitude' => 1, 'longitude' => 2]);
    }

    public function testGetNearbyDereferencesEntries()
    {
        $this->assertEquals(
            [3,4], 
            $this->_client->getNearby(['latitude'=>'lat', 'longitude'=>'lon'])
        );
    }

    public function testGetNearbyWithParams()
    {
        $this->setFetchExpectation('entries/nearby/1,2', ['page' => '2']);
        $this->_client->getNearby(['latitude' => 1, 'longitude' => 2, 'page' => '2']);
        $this->setFetchExpectation('entries/nearby/1,2', ['page' => '2', 'radius' => '10']);
        $this->_client->getNearby(['latitude' => 1, 'longitude' => 2, 'page' => '2', 'radius' => '10']);
    }

    public function testGetEntryFetchesCorrectEndpoint()
    {
        $this->setFetchExpectation('entries/foo');
        $this->_client->getEntry(['id' => 'foo']);
        $this->setFetchExpectation('entries/foo');
        $this->_client->getEntry('foo');
    }

    private function setFetchExpectation($fetchEndpoint, $params=array())
    {
        $this->_fetcher = $this->getMock("DailymilePHP\\Fetcher");
        $this->_fetcher->expects($this->once())->method('fetch')->with($fetchEndpoint, $params);
        $this->_client->setFetcher($this->_fetcher);
    }

}
