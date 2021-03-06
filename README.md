Stomper
=======

[![Build Status](https://secure.travis-ci.org/jwage/stomper.png?branch=master)](http://travis-ci.org/jwage/stomper)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/jwage/stomper/badges/quality-score.png?s=93985b6c21ad0bf9b94ec09ad7aac69f08ee52d7)](https://scrutinizer-ci.com/g/jwage/stomper/)
[![Code Coverage](https://scrutinizer-ci.com/g/jwage/stomper/badges/coverage.png?s=719548d3afcd89328864f55d45c5d87920874654)](https://scrutinizer-ci.com/g/jwage/stomper/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/81a3d9bc-9a58-442e-9865-8daef94c87c4/mini.png)](https://insight.sensiolabs.com/projects/81a3d9bc-9a58-442e-9865-8daef94c87c4)
[![Latest Stable Version](https://poser.pugx.org/jwage/stomper/v/stable.png)](https://packagist.org/packages/jwage/stomper)
[![Total Downloads](https://poser.pugx.org/jwage/stomper/downloads.png)](https://packagist.org/packages/jwage/stomper)
[![Dependency Status](https://www.versioneye.com/php/jwage:stomper/1.0.0/badge.png)](https://www.versioneye.com/php/jwage:stomper/1.0.0)

PHP Stomp library that provides additional functionality on top of the default Stomp API. 

## What is Stomp?

**From [STOMP Protocol Specification, Version 1.1](http://stomp.github.io/stomp-specification-1.1.html):**

"STOMP is a simple interoperable protocol designed for asynchronous message passing between clients via mediating servers. It defines a text based wire-format for messages passed between these clients and servers."

## What is Stomper?

Stomper is an object oriented library that can be used with the [Stomp PECL](http://pecl.php.net/package/stomp) extension or the [FuseSource Stomp](https://packagist.org/packages/fusesource/stomp-php) library. It provides some additional functionality and abstractions to make reading and writing messages with your PHP applications easier.

## Install

Install Stomper with Composer:

    composer require jwage/stomper

## Setup

```php
use FuseSource\Stomp\Stomp;
use JWage\Stomper\Client\Connection\FuseStompConnection;
use JWage\Stomper\Client\FuseStompClient;

$stomp = new Stomp('tcp://127.0.0.1:61613');
$stompConnection = new FuseStompConnection($stomp, 'guest', 'guest');
$client = new FuseStompClient($stompConnection);
```

## Writing Messages

```php
use JWage\Stomper\Message\Message;
use JWage\Stomper\Message\MessageFactory;

$messageFactory = new MessageFactory();

$message = $messageFactory->createMessage();
$message->setQueueName('queue.name');
$message->setParameters(array('param' => 'value'));

$client->send($message);
```

## Reading Messages

```php
$client->subscribe('queue.name');

if ($client->hasMessage()) {
    $message = $client->readMessage();

    // do something with the $message

    $client->ack($message);
}
```

Or for your convenience you can use the `subscribeClosure()` method:

```php
use JWage\Stomper\Client\ClientInterface;
use JWage\Stomper\Message\MessageInterface;

$client->subscribeClosure('queue.name', function(MessageInterface $message, ClientInterface $client, Loop $loop) {

    $client->ack($message);

    // do something with the $message
});
```

## Resources

- [STOMP Protocol Specification, Version 1.1](http://stomp.github.io/stomp-specification-1.1.html)

## Tests

Run the test suite using PHPUnit:

    $ phpunit

## License

MIT, see LICENSE.
