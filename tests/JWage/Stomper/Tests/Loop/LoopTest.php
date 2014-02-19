<?php

namespace JWage\Stomper\Tests\Loop;

use JWage\Stomper\Loop\Loop;
use PHPUnit_Framework_TestCase;

class LoopTest extends PHPUnit_Framework_TestCase
{
    public function testLoop()
    {
        $test = $this;

        $check = new \stdClass;
        $check->count = 0;

        $loop = new Loop(function(Loop $loop) use ($check) {
            if ($check->count == 2) {
                $loop->stop();
            }
            $check->count++;
        });

        $loop->run();

        $this->assertEquals(3, $check->count);
    }
}
