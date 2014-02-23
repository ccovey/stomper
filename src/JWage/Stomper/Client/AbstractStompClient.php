<?php

namespace JWage\Stomper\Client;

use Closure;
use JWage\Stomper\Client\Connection\ConnectionInterface;
use JWage\Stomper\Client\Connection\Frame\FrameInterface;
use JWage\Stomper\Exception;
use JWage\Stomper\Loop\Loop;
use JWage\Stomper\Message\Message;
use JWage\Stomper\Message\MessageFactory;
use JWage\Stomper\Message\MessageInterface;

abstract class AbstractStompClient implements ClientInterface
{
    protected $connection;
    protected $messageFactory;

    /**
     * Constructs a new stomp client instance.
     *
     * @param ConnectionInterface $connection
     * @param MessageFactory $messageFactory
     */
    public function __construct(
        ConnectionInterface $connection,
        MessageFactory $messageFactory = null
    )
    {
        $this->connection = $connection;
        $this->messageFactory = $messageFactory ?: new MessageFactory();
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
     * Checks whether or not we have connected to stomp.
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->connection->isConnected();
    }

    /**
     * Connects with stomp.
     *
     * @return boolean
     */
    public function connect()
    {
        return $this->connection->connect();
    }

    /**
     * Disconnects from stomp.
     *
     * @return boolean
     */
    public function disconnect()
    {
        return $this->connection->disconnect();
    }

    /**
     * Gets the current stomp connection session id.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->connection->getSessionId();
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

    /**
     * Reads a Message instance when it exists.
     *
     * @return Message|null $message
     */
    public function readMessage()
    {
        $frame = $this->connection->readFrame();

        if ($frame instanceof FrameInterface) {
            $message = $this->messageFactory->createMessage(
                null, $this->jsonDecode($frame->getBody()), $frame->getHeaders()
            );

            $message->setFrame($frame);

            return $message;
        }
    }

    /**
     * Indicates whether or not there is a Message ready to read.
     *
     * @return boolean
     */
    public function hasMessage()
    {
        return $this->connection->hasFrame();
    }

    /**
     * Subscribes to the given queue name and invokes the passed
     * Closure when a new Message is received.
     *
     * @param string $queueName
     * @param Closure $closure
     */
    public function subscribeClosure($queueName, Closure $closure, array $headers = array())
    {
        $this->subscribe($queueName, $headers);

        $client = $this;

        $loop = $this->createLoop(function(Loop $loop) use ($closure, $client) {
            if (!$client->hasMessage()) {
                return;
            }

            if ($message = $client->readMessage()) {
                $closure($message, $client, $loop);
            }
        });

        $loop->run();

        return $loop;
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
        return $this->connection->subscribe($queueName, $headers);
    }

    /**
     * Unsubscribes from a given queue name.
     *
     * @param string $queueName
     * @param array $headers
     */
    public function unsubscribe($queueName, array $headers = array())
    {
        return $this->connection->unsubscribe($queueName, $headers);
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
        return $this->connection->begin($transactionId);
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
        return $this->connection->commit($transactionId);
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
        return $this->connection->abort($transactionId);
    }

    /**
     * Acknowledges consumption of a message.
     *
     * @param Message $message
     * @param string $transactionId
     *
     * @return boolean
     */
    public function ack(MessageInterface $message, $transactionId = null)
    {
        return $this->connection->ack($message->getFrame(), $transactionId);
    }

    /**
     * Sets the read timeout.
     *
     * @param integer $seconds
     * @param integer $microseconds
     */
    public function setReadTimeout($seconds, $microseconds = 0)
    {
        return $this->connection->setReadTimeout($seconds, $microseconds);
    }

    protected function createLoop(Closure $closure)
    {
        return new Loop($closure);
    }

    /**
     * @return string
     */
    protected function jsonEncode($data)
    {
        $jsonEncoded = @json_encode($data);

        if ($jsonEncoded === false) {
            throw Exception::jsonEncodeFailureException();
        }

        return $jsonEncoded;
    }

    /**
     * @param string $json
     */
    protected function jsonDecode($json)
    {
        return json_decode($json, true);
    }
}
