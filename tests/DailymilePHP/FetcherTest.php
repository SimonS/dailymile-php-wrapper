<?php

namespace DailymilePHP;

class FetcherTest extends \PHPUnit_Framework_TestCase {

    private $_fetcher, $_guzzle, $_request, $_response;

    public function setUp()
    {
        $this->_response = $this->getMockBuilder("Guzzle\\Http\\Message\\Response")
            ->disableOriginalConstructor()
            ->getMock();
        $this->_response->expects($this->any())->method('getBody')->will(
            $this->returnValue('{}')
        );

        $this->_request = $this->getMock("Guzzle\\Http\\Message\\RequestInterface");
        $this->_request->expects($this->any())->method('send')
            ->will($this->returnValue($this->_response));

        $this->_guzzle = $this->getMockBuilder("Guzzle\\Http\\Client")->getMock();
        $this->_guzzle->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->_request));

        $this->_fetcher = new Fetcher($this->_guzzle);
    }

    public function testFetchUsesBaseUrlFromConstructor()
    {
        $this->_response->expects($this->once())->method('getBody');
        $this->_request->expects($this->once())->method('send');
        
        $this->_guzzle = $this->getMockBuilder("Guzzle\\Http\\Client")->getMock();
        $this->_guzzle->expects($this->once())
            ->method('get')
            ->with($this->matchesRegularExpression("/^http:\/\/api.dailymile.com\//"))
            ->will($this->returnValue($this->_request));

        $this->_fetcher = new Fetcher($this->_guzzle);
        $this->_fetcher->fetch();
    }

    public function testFetchReturnsDecodedJsonString()
    {
        $this->assertInstanceOf('stdClass', $this->_fetcher->fetch());
    }

    public function testFetchInterpolatesArgumentsAndAppendsJSON()
    {
        $this->setGetExpectation("http://api.dailymile.com/foo.json");
        $this->_fetcher->fetch('foo');
    }

    public function testFetchTakesParamsAndAppendsThemCorrectly()
    {
        $this->setGetExpectation(
            "http://api.dailymile.com/foo.json?param1=bar&param2=baz"
        );
        $this->_fetcher->fetch('foo', ['param1' => 'bar', 'param2' => 'baz']);
    }

    private function setGetExpectation($url)
    {
        $this->_guzzle->expects($this->once())
            ->method('get')
            ->with($url)
            ->will($this->returnValue($this->_request));

        $this->_fetcher = new Fetcher($this->_guzzle);
    }

}
