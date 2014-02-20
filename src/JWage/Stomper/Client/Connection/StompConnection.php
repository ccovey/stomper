<?php

namespace JWage\Stomper\Client\Connection;

use JWage\Stomper\Client\Connection\Frame\FrameFactory;
use Stomp as BaseStomp;

class StompConnection extends AbstractConnection
{
    /**
     * Constructs a StompConnection instance.
     *
     * @param \Stomp $stomp
     * @param string $username
     * @param string $password
     * @param FrameFactory $frameFactory
     */
    public function __construct(BaseStomp $stomp, $username, $password, FrameFactory $frameFactory = null)
    {
        parent::__construct($username, $password, $frameFactory);
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
        return $this->stomp->hasFrame();
    }
}
