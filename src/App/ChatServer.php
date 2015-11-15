<?php
namespace WSCon\App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        
        echo "Servidor rodando..." . PHP_EOL;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        
        echo "Nova Conexão! ({$conn->resourceId})" . PHP_EOL;
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Conexão %d enviando mensagem "%s" para %d outra conexão%s' . PHP_EOL
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            //if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($from->resourceId . ": " . $msg);
            //}
        }
        var_dump($from);
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Conexão {$conn->resourceId} foi desconectada" . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Um erro foi encontrado: {$e->getMessage()}" . PHP_EOL;

        $conn->close();
    }
}