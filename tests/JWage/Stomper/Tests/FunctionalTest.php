<?php

namespace JWage\Stomper\Tests;

use JWage\Stomper\Client\Connection\FuseStompConnection;
use JWage\Stomper\Client\FuseStompClient;
use JWage\Stomper\Message\Message;
use JWage\Stomper\Message\MessageFactory;
use PHPUnit_Framework_TestCase;

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    public function testFunctional()
    {
        $stomp = $this->getMockBuilder('FuseSource\Stomp\Stomp')
            ->disableOriginalConstructor()
            ->getMock();

        $stompConnection = new FuseStompConnection($stomp, 'guest', 'guest');
        $fuseStompClient = new FuseStompClient($stompConnection);
        $messageFactory = new MessageFactory();

        $message = $messageFactory->createMessage();
        $message->setQueueName('queue.name');
        $message->setParameters(array('param' => 'value'));
        $message->setHeaders(array('header' => 'value'));

        $stomp->expects($this->once())
            ->method('send')
            ->with('queue.name', '{"param":"value"}', array('header' => 'value'));

        $fuseStompClient->send($message);
    }
}
