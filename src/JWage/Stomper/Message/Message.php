<?php

namespace JWage\Stomper\Message;

class Message implements MessageInterface
{
    /**
     * @var string
     */
    protected $queueName;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var array
     */
    protected $headers = array();

    /**
     * Construct a new Message instance.
     *
     * @param string $queueName
     * @param array $parameters
     * @param array $headers
     */
    public function __construct(
        $queueName = null,
        array $parameters = array(),
        array $headers = array()
    )
    {
        $this->queueName = $queueName;
        $this->parameters = $parameters;
        $this->headers = $headers;
    }

    /**
     * Set the queue name for this message.
     *
     * @param string $queueName
     */
    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * Get the queue name for this message.
     *
     * @return string $queueName
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * Set the parameters for this message.
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * Gets the parameters for this message.
     *
     * @return array $parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Adds a header to this message.
     *
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Sets the headers for this message.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers = array())
    {
        $this->headers = $headers;
    }

    /**
     * Gets the headers for this message.
     *
     * @return array $headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
