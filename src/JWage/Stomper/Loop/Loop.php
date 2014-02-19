<?php

namespace JWage\Stomper\Loop;

use Closure;

class Loop
{
    private $closure;
    private $running = false;

    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    public function stop()
    {
        $this->running = false;
    }

    public function run()
    {
        $this->running = true;

        $closure = $this->closure;

        while ($this->running) {
            $closure($this);
        }
    }
}
