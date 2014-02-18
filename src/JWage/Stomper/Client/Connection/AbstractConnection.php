<?php

namespace JWage\Stomper\Client\Connection;

use FuseSource\Stomp\Stomp as BaseStomp;

class AbstractConnection implements ConnectionInterface
{
    /**
     * @var object
     */
    protected $stomp;
    protected $username;
    protected $password;
    protected $connected = false;

    /**
     * Gets the wrapped stomp connection instance.
     *
     * @return object
     */
    public function getWrappedStompConnection()
    {
        return $this->stomp;
    }

    /**
     * Checks whether or not we have connected to stomp.
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->connected;
    }

    /**
     * Connects with stomp.
     *
     * @return boolean
     */
    public function connect()
    {
        $result = $this->stomp->connect($this->username, $this->password);

        $this->connected = true;

        return $result;
    }

    /**
     * Disconnects from stomp.
     *
     * @return boolean
     */
    public function disconnect()
    {
        $result = $this->stomp->disconnect();

        $this->connected = false;

        return $result;
    }

    /**
     * Sends a message.
     *
     * @param string $queueName
     * @param string $message
     * @param array $headers
     */
    public function send($queueName, $message, array $headers = array())
    {
        if (!$this->connected) {
            $this->connect();
        }

        return $this->stomp->send($queueName, $message, $headers);
    }
}
