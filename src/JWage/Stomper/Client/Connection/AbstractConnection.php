<?php

namespace JWage\Stomper\Client\Connection;

use FuseSource\Stomp\Stomp as BaseStomp;

abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * @var object
     */
    protected $stomp;
    protected $username;
    protected $password;
    protected $connected = false;

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
     * @param string|Frame $message
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
     * @return StompFrame|FuseSource\Stomp\Frame
     */
    public function readFrame()
    {
        $this->connect();
        return $this->stomp->readFrame();
    }
}
