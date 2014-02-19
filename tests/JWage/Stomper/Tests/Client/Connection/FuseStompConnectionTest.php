<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\Connection\FuseStompConnection;
use PHPUnit_Framework_TestCase;

class FuseStompConnectionTest extends PHPUnit_Framework_TestCase
{
    private $stomp;
    private $connection;

    protected function setUp()
    {
        $this->stomp = $this->getMockBuilder('FuseSource\Stomp\Stomp')
            ->disableOriginalConstructor()
            ->getMock();

        $this->connection = new FuseStompConnection($this->stomp, 'guest', 'guest');
    }

    public function testConstruct()
    {
        $this->assertSame($this->stomp, $this->connection->getWrappedStompConnection());
    }

    public function testHasFrame()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('hasFrameToRead')
            ->will($this->returnValue(true));

       $this->assertTrue($this->connection->hasFrame());
    }
}
