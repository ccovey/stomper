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
     * Sends a message.
     *
     * @param string $queueName
     * @param string $message
     * @param array $headers
     */
    public function send($queueName, $message, array $headers = array());
}
