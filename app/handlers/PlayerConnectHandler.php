<?php

namespace App\handlers;

use BeyondCode\LaravelWebSockets\Apps\App;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class PlayerConnectHandler implements MessageComponentInterface
{
    protected $connections = [];

    public function onOpen(ConnectionInterface $connection)
    {
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));
        $connection->socketId = $socketId;
        $connection->app = App::findById(env('PUSHER_APP_ID'));

        $this->connections[$socketId] = $connection;

        $connection->send("Welcome to the WebSocket!");
        $this->broadcastMessage("A new user has joined!");
    }
    
    public function onClose(ConnectionInterface $connection)
    {
        $connection->send("bye!");
    }

    public function onError(ConnectionInterface $connection, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $msg)
    {
        $this->broadcastMessage($msg);
    }

    protected function broadcastMessage($message)
    {
        foreach ($this->connections as $conn) {
            $conn->send($message);
        }
    }
}