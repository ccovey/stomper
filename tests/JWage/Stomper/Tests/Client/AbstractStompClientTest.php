<?php

namespace JWage\Stomper\Tests\Client;

use FuseSource\Stomp\Frame;
use JWage\Stomper\Client\AbstractStompClient;
use JWage\Stomper\Loop\Loop;
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

    public function testIsConnected()
    {
        $this->connection->expects($this->once())
            ->method('isConnected')
            ->will($this->returnValue(true));

        $this->assertTrue($this->client->isConnected());
    }

    public function testConnect()
    {
        $this->connection->expects($this->once())
            ->method('connect')
            ->will($this->returnValue(true));

        $this->assertTrue($this->client->connect());
    }

    public function testDisconnect()
    {
        $this->connection->expects($this->once())
            ->method('disconnect')
            ->will($this->returnValue(true));

        $this->assertTrue($this->client->disconnect());
    }

    public function testGetSessionId()
    {
        $this->connection->expects($this->once())
            ->method('getSessionId')
            ->will($this->returnValue('sessionId'));

        $this->assertEquals('sessionId', $this->client->getSessionId());
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

    public function testReadMessage()
    {
        $parameters = array('parameter' => 'value');
        $headers = array('header' => 'value');

        $frame = new Frame('TEST', $headers, json_encode($parameters));

        $this->connection->expects($this->once())
            ->method('readFrame')
            ->will($this->returnValue($frame));

        $message = $this->client->readMessage();
        $this->assertNull($message->getQueueName());
        $this->assertEquals($parameters, $message->getParameters());
        $this->assertEquals($headers, $message->getHeaders());
        $this->assertSame($frame, $message->getFrame());
    }

    public function testHasMessage()
    {
        $this->connection->expects($this->once())
            ->method('hasFrame')
            ->will($this->returnValue(true));

        $this->assertTrue($this->client->hasMessage());
    }

    public function testSubscribeClosure()
    {
        $parameters = array('parameter' => 'value');
        $headers = array('header' => 'value');

        $this->connection->expects($this->once())
            ->method('subscribe')
            ->with('queue.name', $headers);

        $this->connection->expects($this->once())
            ->method('hasFrame')
            ->will($this->returnValue(true));

        $frame = new Frame('TEST', $headers, json_encode($parameters));

        $this->connection->expects($this->once())
            ->method('readFrame')
            ->will($this->returnValue($frame));

        $test = $this;

        $loop = $this->client->subscribeClosure('queue.name', function(Message $message, TestStompClient $client, Loop $loop) use ($test, $parameters, $headers) {
            $loop->stop();
            $test->assertNull($message->getQueueName());
            $test->assertEquals($parameters, $message->getParameters());
            $test->assertEquals($headers, $message->getHeaders());
        }, $headers);

        $loop->run();
    }

    public function testSubscribe()
    {
        $this->connection->expects($this->once())
            ->method('subscribe')
            ->with('queue.name', array('header' => 'value'));

        $this->client->subscribe('queue.name', array('header' => 'value'));
    }

    public function testUnsubscribe()
    {
        $this->connection->expects($this->once())
            ->method('unsubscribe')
            ->with('queue.name', array('header' => 'value'));

        $this->client->unsubscribe('queue.name', array('header' => 'value'));
    }

    public function testBegin()
    {
        $this->connection->expects($this->once())
            ->method('begin')
            ->with('transactionId');

        $this->client->begin('transactionId');
    }

    public function testCommit()
    {
        $this->connection->expects($this->once())
            ->method('commit')
            ->with('transactionId');

        $this->client->commit('transactionId');
    }

    public function testAbort()
    {
        $this->connection->expects($this->once())
            ->method('abort')
            ->with('transactionId');

        $this->client->abort('transactionId');
    }

    public function testAck()
    {
        $message = new Message();
        $message->setFrame(new Frame());

        $this->connection->expects($this->once())
            ->method('ack')
            ->with($message->getFrame(), 'transactionId');

        $this->client->ack($message, 'transactionId');
    }

    public function testSetReadTimeout()
    {
        $this->connection->expects($this->once())
            ->method('setReadTimeout')
            ->with(1, 2);

        $this->client->setReadTimeout(1, 2);
    }
}

class TestStompClient extends AbstractStompClient
{
}
