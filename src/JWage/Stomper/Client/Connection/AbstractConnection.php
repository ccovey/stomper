<?php

namespace JWage\Stomper\Client\Connection;

use JWage\Stomper\Client\Connection\Frame\FrameFactory;

abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * @var object
     */
    protected $stomp;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var FrameFactory
     */
    protected $frameFactory;

    /**
     * @var boolean
     */
    protected $connected = false;

    /**
     * @var int
     */
    protected $reconnectTimeout;

    /**
     * @var int
     */
    protected $connectionTime;

    /**
     * Constructs a connection instance.
     *
     * @param string $username
     * @param string $password
     * @param FrameFactory $frameFactory
     */
    public function __construct($username, $password, FrameFactory $frameFactory = null, $reconnectTimeout = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->frameFactory = $frameFactory ?: $this->createDefaultFrameFactory();
        $this->reconnectTimeout = $reconnectTimeout;
        $this->connectionTime = time();
    }

    /**
     * Indicates whether or not there is a frame ready to read.
     *
     * @return boolean
     */
    abstract public function hasFrame();

    /**
     * Gets the wrapped stomp connection instance.
     *
     * @return object
     */
    public function getWrappedStompConnection()
    {
        return $this->stomp;
    }

    /**
     * Checks whether or not we have connected to stomp.
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->connected;
    }

    /**
     * Connects with stomp.
     *
     * @return boolean
     */
    public function connect()
    {
        if ($this->reconnectTimeout > 0) {
            $this->checkTimeout();
        }

        if ($this->connected === false) {
            $result = $this->stomp->connect($this->username, $this->password);

            $this->connected = true;

            return $result;
        }
    }

    /**
     * Disconnects from stomp.
     *
     * @return boolean
     */
    public function disconnect()
    {
        $result = $this->stomp->disconnect();

        $this->connected = false;

        return $result;
    }

    /**
     * Gets the current stomp connection session id.
     *
     * @return string
     */
    public function getSessionId()
    {
        $this->connect();
        return $this->stomp->getSessionId();
    }

    /**
     * Sends a message.
     *
     * @param string $queueName
     * @param string $message
     * @param array $headers
     */
    public function send($queueName, $message, array $headers = array())
    {
        $this->connect();
        return $this->stomp->send($queueName, $message, $headers);
    }

    /**
     * Subscribes to a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     *
     * @return boolean
     */
    public function subscribe($queueName, array $headers = array())
    {
        $this->connect();
        return $this->stomp->subscribe($queueName, $headers);
    }

    /**
     * Unsubscribes from a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     */
    public function unsubscribe($queueName, array $headers = array())
    {
        $this->connect();
        return $this->stomp->unsubscribe($queueName, $headers);
    }

    /**
     * Starts a transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    public function begin($transactionId = null)
    {
        $this->connect();
        return $this->stomp->begin($transactionId);
    }

    /**
     * Commits the current transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    public function commit($transactionId = null)
    {
        $this->connect();
        return $this->stomp->commit($transactionId);
    }

    /**
     * Rolls back the current transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    public function abort($transactionId = null)
    {
        $this->connect();
        return $this->stomp->abort($transactionId);
    }

    /**
     * Acknowledges consumption of a message.
     *
     * @param string|\JWage\Stomper\Client\Connection\Frame\FrameInterface $message
     * @param string $transactionId
     *
     * @return boolean
     */
    public function ack($message, $transactionId = null)
    {
        $this->connect();
        return $this->stomp->ack($message, $transactionId);
    }

    /**
     * Sets the read timeout.
     *
     * @param integer $seconds
     * @param integer $microseconds
     */
    public function setReadTimeout($seconds, $microseconds = 0)
    {
        $this->connect();
        return $this->stomp->setReadTimeout($seconds, $microseconds);
    }

    /**
     * Reads the next frame.
     *
     * @return \JWage\Stomper\Client\Connection\Frame\FrameInterface
     */
    public function readFrame()
    {
        $this->connect();
        return $this->frameFactory->createFromClientFrame($this->stomp->readFrame());
    }

    /**
     * Creates the default FrameFactory instance that creates Stomper frame instances
     * from the client connection frame instance.
     */
    protected function createDefaultFrameFactory()
    {
        return new FrameFactory();
    }

    /**
     * Check connection time against current time to determine if we should reconnect.
     */
    protected function checkTimeout()
    {
        $timestamp = time();
        if (($timestamp - $this->connectionTime) > $this->reconnectTimeout) {
            $this->disconnect();
            $this->connectionTime = $timestamp;
        }
    }
}
