<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\AbstractStompClient;
use JWage\Stomper\Message\Message;
use PHPUnit_Framework_TestCase;

class AbstractStompClientTest extends PHPUnit_Framework_TestCase
{
    private $connection;
    private $client;

    protected function setUp()
    {
        $this->connection = $this->getMockBuilder('JWage\Stomper\Client\Connection\ConnectionInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new TestStompClient($this->connection);
    }

    public function testGetConnection()
    {
        $this->assertSame($this->connection, $this->client->getConnection());
    }

    public function testSend()
    {
        $message = new Message();
        $message->setQueueName('queue.name');
        $message->setParameters(array('param' => 'value'));
        $message->setHeaders(array('header' => 'value'));

        $this->connection->expects($this->once())
            ->method('send')
            ->with('queue.name', '{"param":"value"}', array('header' => 'value'));

        $this->client->send($message);
    }
}

class TestStompClient extends AbstractStompClient
{
}
