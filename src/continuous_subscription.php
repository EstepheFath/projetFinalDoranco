<?php
/* */
require __DIR__ . '/vendor/autoload.php';

use WebSocket\Client;
use WebSocket\Middleware\CloseHandler;
use WebSocket\Middleware\PingResponder;
use WebSocket\Middleware\PingInterval;

$client = new Client("wss://echo.websocket.org/");
$client
    ->addMiddleware(new CloseHandler())
    ->addMiddleware(new PingResponder())
    ->addMiddleware(new PingInterval(interval: 30))
    ->onHandshake(function ($client, $connection, $request, $response) {
        // Envoyer un message initial (par exemple, autorisation)
        $client->text("Message initial !");
    })
    ->onText(function ($client, $connection, $message) {
        echo "Message reçu : {$message->getContent()}\n";
        // Répondre au serveur
        $client->text("Réponse au serveur !");
    })
    ->onError(function ($client, $connection, $exception) {
        echo "Erreur : {$exception->getMessage()}\n";
        if (!$client->isRunning()) {
            $client->start();
        }
    })
    ->start();
