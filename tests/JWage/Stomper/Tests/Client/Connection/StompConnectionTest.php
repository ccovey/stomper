<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\Connection\StompConnection;
use PHPUnit_Framework_TestCase;

class StompConnectionTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $stomp = $this->getMockBuilder('Stomp')
            ->disableOriginalConstructor()
            ->getMock();

        $connection = new StompConnection($stomp, 'guest', 'guest');

        $this->assertSame($stomp, $connection->getWrappedStompConnection());
    }
}
