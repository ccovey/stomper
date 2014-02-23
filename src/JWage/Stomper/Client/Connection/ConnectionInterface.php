<?php

namespace JWage\Stomper\Client\Connection;

interface ConnectionInterface
{
    /**
     * Gets the wrapped stomp connection instance.
     *
     * @return object
     */
    public function getWrappedStompConnection();

    /**
     * Checks whether or not we have connected to stomp.
     *
     * @return boolean
     */
    public function isConnected();

    /**
     * Connects with stomp.
     *
     * @return boolean
     */
    public function connect();

    /**
     * Disconnects from stomp.
     *
     * @return boolean
     */
    public function disconnect();

    /**
     * Gets the current stomp connection session id.
     *
     * @return string
     */
    public function getSessionId();

    /**
     * Sends a message.
     *
     * @param string $queueName
     * @param string $message
     * @param array $headers
     *
     * @return boolean
     */
    public function send($queueName, $message, array $headers = array());

    /**
     * Subscribes to a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     *
     * @return boolean
     */
    public function subscribe($queueName, array $headers = array());

    /**
     * Unsubscribes from a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     */
    public function unsubscribe($queueName, array $headers = array());

    /**
     * Starts a transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    public function begin($transactionId = null);

    /**
     * Commits the current transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    public function commit($transactionId = null);

    /**
     * Rolls back the current transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    public function abort($transactionId = null);

    /**
     * Acknowledges consumption of a message.
     *
     * @param Frame\FrameInterface $message
     * @param string $transactionId
     *
     * @return boolean
     */
    public function ack($message, $transactionId = null);

    /**
     * Sets the read timeout.
     *
     * @param integer $seconds
     * @param integer $microseconds
     */
    public function setReadTimeout($seconds, $microseconds = 0);

    /**
     * Reads the next frame.
     *
     * @return \JWage\Stomper\Client\Connection\Frame\FrameInterface
     */
    public function readFrame();

    /**
     * Indicates whether or not there is a frame ready to read.
     *
     * @return boolean
     */
    public function hasFrame();
}
