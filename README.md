Stomper
=======

[![Build Status](https://secure.travis-ci.org/jwage/stomper.png?branch=master)](http://travis-ci.org/jwage/stomper)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/jwage/stomper/badges/quality-score.png?s=93985b6c21ad0bf9b94ec09ad7aac69f08ee52d7)](https://scrutinizer-ci.com/g/jwage/stomper/)

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
