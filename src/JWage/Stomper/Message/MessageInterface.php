<?php

namespace JWage\Stomper\Message;

interface MessageInterface
{
    /**
     * Gets the raw Frame object for this message.
     *
     * @return StompFrame|FuseSource\Stomp\Frame $frame
     */
    public function getFrame();

    /**
     * Gets the queue name for this message.
     *
     * @return string $queueName
     */
    public function getQueueName();

    /**
     * Gets the parameters for this message.
     *
     * @return array $parameters
     */
    public function getParameters();

    /**
     * Gets the headers for this message.
     *
     * @return array $headers
     */
    public function getHeaders();
}
