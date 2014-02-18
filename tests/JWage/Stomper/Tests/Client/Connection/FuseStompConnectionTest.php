<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\Connection\FuseStompConnection;
use PHPUnit_Framework_TestCase;

class FuseStompConnectionTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $stomp = $this->getMockBuilder('FuseSource\Stomp\Stomp')
            ->disableOriginalConstructor()
            ->getMock();

        $connection = new FuseStompConnection($stomp, 'guest', 'guest');

        $this->assertSame($stomp, $connection->getWrappedStompConnection());
    }
}
