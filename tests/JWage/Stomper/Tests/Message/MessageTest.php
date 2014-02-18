<?php

namespace JWage\Stomper\Tests\Message;

use JWage\Stomper\Message\Message;
use PHPUnit_Framework_TestCase;

class MessageTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $message = new Message('queue.name', array('key' => 'value'), array('header' => 'value'));
        $this->assertEquals('queue.name', $message->getQueueName());
        $this->assertEquals(array('key' => 'value'), $message->getParameters());
        $this->assertEquals(array('header' => 'value'), $message->getHeaders());
    }

    public function testQueueName()
    {
        $message = new Message();

        $this->assertNull($message->getQueueName());

        $message->setQueueName('queue.name');

        $this->assertEquals('queue.name', $message->getQueueName());
    }

    public function testParameters()
    {
        $message = new Message();

        $this->assertEmpty($message->getParameters());

        $message->setParameters(array('key' => 'value'));

        $this->assertEquals(array('key' => 'value'), $message->getParameters());
    }

    public function testHeaders()
    {
        $message = new Message();

        $this->assertEmpty($message->getHeaders());

        $message->addHeader('name', 'value');

        $this->assertEquals(array('name' => 'value'), $message->getHeaders());

        $message->setHeaders(array());

        $this->assertEmpty($message->getHeaders());
    }
}
