<?php

namespace JWage\Stomper\Tests\Client;

use JWage\Stomper\Client\Connection\AbstractConnection;
use JWage\Stomper\Message\Message;
use PHPUnit_Framework_TestCase;

class AbstractConnectionTest extends PHPUnit_Framework_TestCase
{
    private $stomp;
    private $connection;

    protected function setUp()
    {
        $this->stomp = new StompTest();
        $this->connection = new ConnectionTest($this->stomp);
    }

    public function testConnect()
    {
        $this->assertFalse($this->stomp->connected);

        $this->connection->connect('guest', 'guest');

        $this->assertTrue($this->stomp->connected);
    }

    public function testDisconnect()
    {
        $this->assertFalse($this->stomp->disconnected);

        $this->connection->disconnect();

        $this->assertTrue($this->stomp->disconnected);
    }

    public function testSend()
    {
        $this->connection->send('queue.name', 'the message', array('header' => 'value'));

        $this->assertTrue($this->stomp->connected);
        $this->assertEquals(array('queue.name', 'the message', array('header' => 'value')), $this->stomp->sent[0]);
    }
}

class ConnectionTest extends AbstractConnection
{
    public function __construct(StompTest $stomp)
    {
        $this->stomp = $stomp;
    }
}

class StompTest
{
    public $connected = false;
    public $disconnected = false;
    public $sent = array();

    public function connect($username, $password)
    {
        $this->connected = true;
    }

    public function disconnect()
    {
        $this->disconnected = true;
    }

    public function send($queueName, $message, array $headers = array())
    {
        $this->sent[] = array($queueName, $message, $headers);
    }
}
