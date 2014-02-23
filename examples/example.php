<?php

require __DIR__ . '/../vendor/autoload.php';

use FuseSource\Stomp\Stomp;
use JWage\Stomper\Client\Connection\FuseStompConnection;
use JWage\Stomper\Client\FuseStompClient;
use JWage\Stomper\Message\MessageFactory;

$config = require __DIR__ . '/config/config.php';

$stomp = new Stomp(sprintf('tcp://%s:%s', $config['host'], $config['port']));
$connection = new FuseStompConnection($stomp, $config['username'], $config['password']);
$client = new FuseStompClient($connection);

$messageFactory = new MessageFactory();

$message = $messageFactory->createMessage();
$message->setQueueName('jms.queue.testing');
$message->setParameters(array('param' => 'value'));
$message->setHeaders(array('header' => 'value'));

$client->send($message);

$client->subscribe('jms.queue.testing');

$receivedMessage = $client->readMessage();

print_r($receivedMessage);
