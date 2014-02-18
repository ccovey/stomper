<?php

namespace JWage\Stomper\Message;

class MessageFactory
{
    /**
     * Create a new Message instance.
     *
     * @param string $queueName
     * @param array $parameters
     * @param array $headers
     */
    public function createMessage(
        $queueName = null,
        array $parameters = array(),
        array $headers = array()
    )
    {
        return new Message($queueName, $parameters, $headers);
    }
}
