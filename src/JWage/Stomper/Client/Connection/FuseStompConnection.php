<?php

namespace JWage\Stomper\Client\Connection;

use FuseSource\Stomp\Stomp as BaseStomp;

class FuseStompConnection extends AbstractConnection
{
    /**
     * Constructs a FuseStompConnection instance.
     *
     * @param \FuseSource\Stomp\Stomp $stomp
     * @param string $username
     * @param string $password
     */
    public function __construct(BaseStomp $stomp, $username, $password)
    {
        $this->stomp = $stomp;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Indicates whether or not there is a frame ready to read.
     *
     * @return boolean
     */
    public function hasFrame()
    {
        $this->connect();
        return $this->stomp->hasFrameToRead();
    }
}
