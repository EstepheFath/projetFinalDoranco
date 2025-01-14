<?php

require __DIR__ . '/vendor/autoload.php';

use WebSocket\Server;

$server = new Server();
$server
    ->onText(function ($server, $connection, $message) {
        echo "Message reçu : {$message->getContent()}\n";
        // Répondre avec le même message
        $connection->text($message->getContent());
    })
    ->start();
