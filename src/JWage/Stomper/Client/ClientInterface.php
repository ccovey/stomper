<?php

namespace JWage\Stomper\Client;

use JWage\Stomper\Message\MessageInterface;

interface ClientInterface
{
    /**
     * Sends a Message instance.
     *
     * @param MessageInterface $message
     */
    function send(MessageInterface $message);
}
