Stomper
=======

[![Build Status](https://secure.travis-ci.org/jwage/stomper.png?branch=master)](http://travis-ci.org/jwage/stomper)

## Install

Install Stomper with Composer:

    composer require jwage/stomper

## Usage

    use FuseSource\Stomp\Stomp;
    use JWage\Stomper\Client\Connection\FuseStompConnection;
    use JWage\Stomper\Client\FuseStompClient;
    use JWage\Stomper\Message\Message;
    use JWage\Stomper\Message\MessageFactory;

    $stomp = new Stomp('tcp://127.0.0.1:61613');
    $stompConnection = new FuseStompConnection($stomp, 'guest', 'guest');
    $fuseStompClient = new FuseStompClient($stompConnection);
    $messageFactory = new MessageFactory();

    $message = $messageFactory->createMessage();
    $message->setQueueName('queue.name');
    $message->setParameters(array('param' => 'value'));

    $fuseStompClient->send($message);
