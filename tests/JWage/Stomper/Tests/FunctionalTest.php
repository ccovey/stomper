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

    public function testFunctionalHornetQ()
    {
        $host = 'tcp://127.0.0.1:61613';
        $consumer = new FuseStompClient(new FuseStompConnection(new \FuseSource\Stomp\Stomp($host), 'guest', 'guest'));

        try {
            $consumer->connect();
        } catch (\FuseSource\Stomp\Exception\StompException $e) {
            $this->markTestSkipped(sprintf(sprintf('Could not connect to HornetQ at %s', $host)));
        }

        $publisher = new FuseStompClient(new FuseStompConnection(new \FuseSource\Stomp\Stomp($host), 'guest', 'guest'));

        $messageFactory = new MessageFactory();

        $message = $messageFactory->createMessage();
        $message->setQueueName('jms.queue.testing');
        $message->setParameters(array('param' => 'value'));
        $message->setHeaders(array('header' => 'value'));

        $publisher->send($message);

        $consumer->subscribe('jms.queue.testing');

        $receivedMessage = $consumer->readMessage();
        $receivedHeaders = $receivedMessage->getHeaders();

        $this->assertInstanceOf('JWage\Stomper\Message\Message', $receivedMessage);
        $this->assertEquals($message->getParameters(), $receivedMessage->getParameters());
        $this->assertTrue(isset($receivedHeaders['header']));
        $this->assertEquals('value', $receivedHeaders['header']);
    }
}
