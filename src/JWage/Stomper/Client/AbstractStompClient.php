<?php

namespace JWage\Stomper\Client;

use JWage\Stomper\Client\Connection\ConnectionInterface;
use JWage\Stomper\Exception;
use JWage\Stomper\Message\MessageInterface;

abstract class AbstractStompClient implements ClientInterface
{
    protected $connection;

    /**
     * Constructs a new stomp client instance.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Gets the stomp connection.
     *
     * @return ConnectionInterface $connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Sends a Message instance.
     *
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message)
    {
        $encoded = $this->jsonEncode($message->getParameters());

        $this->connection->send(
            $message->getQueueName(), $encoded, $message->getHeaders()
        );
    }

    protected function jsonEncode($data)
    {
        $jsonEncoded = @json_encode($data);

        if ($jsonEncoded === false) {
            throw Exception::jsonEncodeFailureException($data);
        }

        return $jsonEncoded;
    }
}
