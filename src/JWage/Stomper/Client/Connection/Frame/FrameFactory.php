<?php

namespace JWage\Stomper\Client\Connection\Frame;

use FuseSource\Stomp\Frame as ClientFuseStompFrame;
use StompFrame as ClientStompFrame;

class FrameFactory
{
    public function createFromClientFrame($frame)
    {
        switch (true) {
            case $frame instanceof ClientFuseStompFrame:
                return $this->createFuseStompFrame($frame);

            case $frame instanceof ClientStompFrame:
                return $this->createStompFrame($frame);
        }
    }

    protected function createFuseStompFrame(ClientFuseStompFrame $frame)
    {
        return new FuseStompFrame($frame);
    }

    protected function createStompFrame(ClientStompFrame $frame)
    {
        return new StompFrame($frame);
    }
}
