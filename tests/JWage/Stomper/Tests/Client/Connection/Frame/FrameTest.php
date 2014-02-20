<?php

namespace JWage\Stomper\Tests\Client;

use PHPUnit_Framework_TestCase;

class FrameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideTestFrame
     */
    public function testFrame($clientFrameClassName, $frameClassName)
    {
        $clientFrame = $this->getMockBuilder($clientFrameClassName)
            ->disableOriginalConstructor()
            ->getMock();

        $clientFrame->command = 'TEST';
        $clientFrame->headers = array('header' => 'value');
        $clientFrame->body = 'test';

        $frame = new $frameClassName($clientFrame);
        $this->assertSame($clientFrame, $frame->getWrappedFrame());
        $this->assertEquals($frame->command, $clientFrame->command);
        $this->assertEquals($frame->headers, $clientFrame->headers);
        $this->assertEquals($frame->body, $clientFrame->body);
    }

    public function provideTestFrame()
    {
        return array(
            array('FuseSource\Stomp\Frame', 'JWage\Stomper\Client\Connection\Frame\FuseStompFrame'),
            array('StompFrame', 'JWage\Stomper\Client\Connection\Frame\StompFrame'),
        );
    }
}
