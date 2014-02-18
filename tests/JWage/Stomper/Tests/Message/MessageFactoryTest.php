<?php

namespace JWage\Stomper\Tests\Message;

use JWage\Stomper\Message\MessageFactory;
use PHPUnit_Framework_TestCase;

class MessageFactoryTest extends PHPUnit_Framework_TestCase
{
    private $messageFactory;

    protected function setUp()
    {
        $this->messageFactory = new MessageFactory();
    }

    public function testCreateMessageWithNoParams()
    {
        $message = $this->messageFactory->createMessage();
        $this->assertInstanceOf('JWage\Stomper\Message\Message', $message);
        $this->assertNull($message->getQueueName());
        $this->assertEquals(array(), $message->getParameters());
        $this->assertEquals(array(), $message->getHeaders());
    }

    public function testCreateMessageWithParams()
    {
        $message = $this->messageFactory->createMessage('queue.name', array('key' => 'value'), array('header' => 'value'));
        $this->assertInstanceOf('JWage\Stomper\Message\Message', $message);
        $this->assertEquals('queue.name', $message->getQueueName());
        $this->assertEquals(array('key' => 'value'), $message->getParameters());
        $this->assertEquals(array('header' => 'value'), $message->getHeaders());
    }
}
