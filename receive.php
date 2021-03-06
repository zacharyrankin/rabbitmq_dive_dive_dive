<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$channel->basic_consume('hello', '', false, true, false, false, function ($msg) {
    echo " [x] Received ", $msg->body, "\n";
});

while (count($channel->callbacks)) {
    $channel->wait();
}
