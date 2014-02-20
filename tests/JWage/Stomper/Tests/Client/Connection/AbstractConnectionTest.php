<?php

namespace JWage\Stomper\Tests\Client;

use FuseSource\Stomp\Stomp;
use JWage\Stomper\Client\Connection\AbstractConnection;
use JWage\Stomper\Client\Connection\Frame\FrameFactory;
use JWage\Stomper\Message\Message;
use PHPUnit_Framework_TestCase;

class AbstractConnectionTest extends PHPUnit_Framework_TestCase
{
    private $stomp;
    private $frameFactory;
    private $connection;

    protected function setUp()
    {
        $this->stomp = $this->getMockBuilder('FuseSource\Stomp\Stomp')
            ->disableOriginalConstructor()
            ->getMock();

        $this->frameFactory = $this->getMockBuilder('JWage\Stomper\Client\Connection\Frame\FrameFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->connection = new ConnectionTest($this->stomp, 'guest', 'guest', $this->frameFactory);
    }

    public function testConnect()
    {
        $this->stomp->expects($this->once())
            ->method('connect')
            ->with('guest', 'guest');

        $this->connection->connect();
    }

    public function testDisconnect()
    {
        $this->stomp->expects($this->once())
            ->method('disconnect');

        $this->connection->disconnect();
    }

    public function testGetSessionId()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('getSessionId')
            ->will($this->returnValue('sessionId'));

        $this->assertEquals('sessionId', $this->connection->getSessionId());
    }

    public function testSend()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('send')
            ->with('queue.name', 'the message', array('header' => 'value'));

        $this->connection->send('queue.name', 'the message', array('header' => 'value'));
    }

    public function testSubscribe()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('subscribe')
            ->with('queue.name', array('header' => 'value'));

        $this->connection->subscribe('queue.name', array('header' => 'value'));
    }

    public function testUnsubscribe()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('unsubscribe')
            ->with('queue.name', array('header' => 'value'));

        $this->connection->unsubscribe('queue.name', array('header' => 'value'));
    }

    public function testBegin()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('begin')
            ->with('transactionId');

        $this->connection->begin('transactionId');
    }

    public function testCommit()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('commit')
            ->with('transactionId');

        $this->connection->commit('transactionId');
    }

    public function testAbort()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('abort')
            ->with('transactionId');

        $this->connection->abort('transactionId');
    }

    public function testAck()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('ack')
            ->with('message', 'transactionId');

        $this->connection->ack('message', 'transactionId');
    }

    public function testSetReadTimeout()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('setReadTimeout')
            ->with(5, 1);

        $this->connection->setReadTimeout(5, 1);
    }

    public function testReadFrame()
    {
        $clientFrame = $this->getMockBuilder('FuseSource\Stomp\Frame')
            ->disableOriginalConstructor()
            ->getMock();

        $stomperFrame = $this->getMockBuilder('JWage\Stomper\Client\Connection\Frame\FrameInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->stomp->expects($this->once())
            ->method('connect');

        $this->frameFactory->expects($this->once())
            ->method('createFromClientFrame')
            ->with($clientFrame)
            ->will($this->returnValue($stomperFrame));

        $this->stomp->expects($this->once())
            ->method('readFrame')
            ->will($this->returnValue($clientFrame));

        $this->assertSame($stomperFrame, $this->connection->readFrame());
    }

    public function testHasFrame()
    {
        $this->stomp->expects($this->once())
            ->method('connect');

        $this->stomp->expects($this->once())
            ->method('hasFrameToRead')
            ->will($this->returnValue(true));

       $this->assertTrue($this->connection->hasFrame());
    }
}

class ConnectionTest extends AbstractConnection
{
    public function __construct(Stomp $stomp, $username, $password, FrameFactory $frameFactory = null)
    {
        parent::__construct($username, $password, $frameFactory);
        $this->stomp = $stomp;
    }

    public function hasFrame()
    {
        $this->connect();
        return $this->stomp->hasFrameToRead();
    }
}
