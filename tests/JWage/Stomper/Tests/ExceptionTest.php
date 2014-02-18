<?php

namespace JWage\Stomper\Tests;

use JWage\Stomper\Exception;
use PHPUnit_Framework_TestCase;

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException JWage\Stomper\Exception
     * @exceptedExceptionMessage Could not encode data to json for message parameters. Failed with error: Unknown error
     */
    public function testJsonEncodeFailureException()
    {
        throw Exception::jsonEncodeFailureException(array('data'));
    }
}
