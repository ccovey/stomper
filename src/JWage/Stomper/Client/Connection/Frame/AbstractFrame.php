<?php

namespace JWage\Stomper\Client\Connection\Frame;

abstract class AbstractFrame implements FrameInterface
{
    /**
     * @var string
     */
    public $command;

    /**
     * @var array
     */
    public $headers = array();

    /**
     * @var string
     */
    public $body;

    /**
     * @var \StompFrame|\FuseSource\Stomp\Frame
     */
    private $frame;

    /**
     * Constructs a new Frame instance.
     *
     * @param string $command
     * @param array $headers
     * @param string $body
     */
    public function __construct ($frame)
    {
        $this->frame = $frame;
        $this->command = $frame->command;
        $this->headers = $frame->headers;
        $this->body = $frame->body;
    }

    /**
     * Gets the client frame object this frame is wrapped around.
     *
     * @return \StompFrame|\FuseSource\Stomp\Frame
     */
    public function getWrappedFrame()
    {
        return $this->frame;
    }

    /**
     * @inheritDoc
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }
}
