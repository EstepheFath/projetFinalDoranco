<?php
/* */
require __DIR__ . '/vendor/autoload.php';

use WebSocket\Client;
use WebSocket\Server;
use WebSocket\Test\EchoLog;

// Configurer un logger simple
$logger = new EchoLog();

// Client WebSocket
$client = new Client('wss://echo.websocket.org/');
$client->setLogger($logger);

// Serveur WebSocket
$server = new Server();
$server->setLogger($logger);
