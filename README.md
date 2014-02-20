Stomper
=======

[![Build Status](https://secure.travis-ci.org/jwage/stomper.png?branch=master)](http://travis-ci.org/jwage/stomper)

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

## Tests

Run the test suite using PHPUnit:

    $ phpunit

## License

MIT, see LICENSE.
