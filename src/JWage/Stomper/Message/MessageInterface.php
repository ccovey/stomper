<?php

namespace JWage\Stomper\Message;

interface MessageInterface
{
    /**
     * Get the queue name for this message.
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
