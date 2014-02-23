<?php

namespace JWage\Stomper\Client\Connection\Frame;

interface FrameInterface
{
    /**
     * Gets the client frame object this frame is wrapped around.
     *
     * @return \StompFrame|\FuseSource\Stomp\Frame
     */
    public function getWrappedFrame();

    /**
     * @return string
     */
    public function getCommand();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return string
     */
    public function getBody();
}
