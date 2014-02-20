<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\Connection\Frame\FrameFactory;
use PHPUnit_Framework_TestCase;

class FrameFactoryTest extends PHPUnit_Framework_TestCase
{
    private $factory;

    protected function setUp()
    {
        $this->factory = new FrameFactory();
    }

    public function testStompFrame()
    {
        $stompClientFrame = $this->getMockBuilder('StompFrame')
            ->disableOriginalConstructor()
            ->getMock();

        $stompClientFrame->command = null;
        $stompClientFrame->headers = array();
        $stompClientFrame->body = null;

        $frame = $this->factory->createFromClientFrame($stompClientFrame);
        $this->assertInstanceOf('JWage\Stomper\Client\Connection\Frame\StompFrame', $frame);
        $this->assertSame($stompClientFrame, $frame->getWrappedFrame());
    }

    public function testFuseStompFrame()
    {
        $fuseStompClientFrame = $this->getMockBuilder('FuseSource\Stomp\Frame')
            ->disableOriginalConstructor()
            ->getMock();

        $fuseStompClientFrame->command = null;
        $fuseStompClientFrame->headers = array();
        $fuseStompClientFrame->body = null;

        $frame = $this->factory->createFromClientFrame($fuseStompClientFrame);
        $this->assertInstanceOf('JWage\Stomper\Client\Connection\Frame\FuseStompFrame', $frame);
        $this->assertSame($fuseStompClientFrame, $frame->getWrappedFrame());
    }
}
