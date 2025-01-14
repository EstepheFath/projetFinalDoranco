<?php

require __DIR__ . '/vendor/autoload.php';

use WebSocket\Client;

// Client avec paramètres aléatoires
$client = new Client("wss://echo.websocket.org/");
while (true) {
    $message = bin2hex(random_bytes(8)); // Message aléatoire
    echo "Envoi : $message\n";
    $client->text($message);

    $response = $client->receive();
    echo "Réponse : {$response->getContent()}\n";
    sleep(1);
}
