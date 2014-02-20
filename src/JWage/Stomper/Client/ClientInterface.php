<?php

namespace JWage\Stomper\Client;

use Closure;
use JWage\Stomper\Message\MessageInterface;

interface ClientInterface
{
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
     * Sends a Message instance.
     *
     * @param MessageInterface $message
     */
    function send(MessageInterface $message);

    /**
     * Reads a Message instance when it exists.
     *
     * @return MessageInterface $message
     */
    function readMessage();

    /**
     * Indicates whether or not there is a Message ready to read.
     *
     * @return boolean
     */
    function hasMessage();

    /**
     * Subscribes to the given queue name and invokes the passed
     * Closure when a new Message is received.
     *
     * @param string $queueName
     * @param Closure $closure
     */
    function subscribeClosure($queueName, Closure $closure);

    /**
     * Subscribes to a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     *
     * @return boolean
     */
    function subscribe($queueName, array $headers = array());


    /**
     * Unsubscribes from a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     */
    function unsubscribe($queueName, array $headers = array());

    /**
     * Starts a transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    function begin($transactionId = null);

    /**
     * Commits the current transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    function commit($transactionId = null);

    /**
     * Rolls back the current transaction.
     *
     * @param string $transactionId
     *
     * @return boolean
     */
    function abort($transactionId = null);

    /**
     * Acknowledges consumption of a message.
     *
     * @param MessageInterface $message
     * @param string $transactionId
     *
     * @return boolean
     */
    function ack(MessageInterface $message, $transactionId = null);

    /**
     * Sets the read timeout.
     *
     * @param integer $seconds
     * @param integer $microseconds
     */
    function setReadTimeout($seconds, $microseconds = 0);
}
