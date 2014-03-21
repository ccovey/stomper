<?php

namespace JWage\Stomper\Client\Connection;

use FuseSource\Stomp\Stomp as BaseStomp;
use JWage\Stomper\Client\Connection\Frame\FrameFactory;

class FuseStompConnection extends AbstractConnection
{
    /**
     * Constructs a FuseStompConnection instance.
     *
     * @param \FuseSource\Stomp\Stomp $stomp
     * @param string $username
     * @param string $password
     * @param FrameFactory $frameFactory
     */
    public function __construct(BaseStomp $stomp, $username, $password, FrameFactory $frameFactory = null, $reconnectTimeout = null)
    {
        parent::__construct($username, $password, $frameFactory, $reconnectTimeout);
        $this->stomp = $stomp;
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
