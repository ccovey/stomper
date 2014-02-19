<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\Connection\StompConnection;
use PHPUnit_Framework_TestCase;

class StompConnectionTest extends PHPUnit_Framework_TestCase
{
    private $stomp;
    private $connection;

    protected function setUp()
    {
        $this->stomp = $this->getMockBuilder('Stomp')
            ->disableOriginalConstructor()
            ->setMethods(array('connect', 'hasFrame'))
            ->getMock();

        $this->connection = new StompConnection($this->stomp, 'guest', 'guest');
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
            ->method('hasFrame')
            ->will($this->returnValue(true));

       $this->assertTrue($this->connection->hasFrame());
    }
}
