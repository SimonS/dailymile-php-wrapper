<?php

namespace DailymilePHP;

class FetcherTest extends \PHPUnit_Framework_TestCase {

    public function testFetchUsesBaseUrlFromConstructor()
    {
        $mockResponse = $this->getMockBuilder("Guzzle\\Http\\Message\\Response")
            ->disableOriginalConstructor()
            ->getMock();
        $mockResponse->expects($this->once())->method('getBody')->will(
            $this->returnValue('{}')
        );

        $mockRequest = $this->getMock("Guzzle\\Http\\Message\\RequestInterface");
        $mockRequest->expects($this->once())->method('send')
            ->will($this->returnValue($mockResponse));
        
        $mockGuzzle = $this->getMockBuilder("Guzzle\\Http\\Client")->getMock();
        $mockGuzzle->expects($this->once())
            ->method('get')
            ->with("http://api.dailymile.com/")
            ->will($this->returnValue($mockRequest));

        $fetcher = new Fetcher($mockGuzzle);
        $fetcher->fetch();
    }

    public function testFetchReturnsDecodedJsonString()
    {
        $mockResponse = $this->getMockBuilder("Guzzle\\Http\\Message\\Response")
            ->disableOriginalConstructor()
            ->getMock();
        $mockResponse->expects($this->once())->method('getBody')->will(
            $this->returnValue('{}')
        );

        $mockRequest = $this->getMock("Guzzle\\Http\\Message\\RequestInterface");
        $mockRequest->expects($this->once())->method('send')
            ->will($this->returnValue($mockResponse));
        
        $mockGuzzle = $this->getMockBuilder("Guzzle\\Http\\Client")->getMock();
        $mockGuzzle->expects($this->once())
            ->method('get')
            ->with("http://api.dailymile.com/")
            ->will($this->returnValue($mockRequest));

        $fetcher = new Fetcher($mockGuzzle);
        $this->assertInstanceOf('stdClass', $fetcher->fetch());
    }

}
