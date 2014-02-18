<?php

namespace JWage\Stomper\Client\Connection;

use Stomp as BaseStomp;

class StompConnection extends AbstractConnection
{
    /**
     * Constructs a StompConnection instance.
     *
     * @param \Stomp $stomp
     * @param string $username
     * @param string $password
     */
    public function __construct(BaseStomp $stomp, $username, $password)
    {
        $this->stomp = $stomp;
        $this->username = $username;
        $this->password = $password;
    }
}
