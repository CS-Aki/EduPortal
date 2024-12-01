<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
      // This will hold all active connections
      protected $clients;

      public function __construct() {
          $this->clients = new \SplObjectStorage; // Using SplObjectStorage to store connections
      }
  
      // Called when a new connection is opened
      public function onOpen(ConnectionInterface $conn) {
          // When a new client connects, add them to the collection of clients
          echo "New connection! ({$conn->resourceId})\n";
          $this->clients->attach($conn);
      }
  
      // Called when a connection is closed
      public function onClose(ConnectionInterface $conn) {
          // When a client disconnects, remove them from the collection
          echo "Connection {$conn->resourceId} has disconnected\n";
          $this->clients->detach($conn);
      }
  
      // Called when a message is received from a client
      public function onMessage(ConnectionInterface $from, $msg) {
          echo "Message from {$from->resourceId}: $msg\n";
  
          // Broadcasting the message to all connected clients except the sender
          foreach ($this->clients as $client) {
              if ($from !== $client) { // Don't send the message back to the sender
                  $client->send($msg);
              }
          }
      }
  
      // Called when an error occurs
      public function onError(ConnectionInterface $conn, \Exception $e) {
          echo "Error: {$e->getMessage()}\n";
          $conn->close();
      }
  
      // A function to get all connected clients
      public function getClients() {
          return $this->clients;
      }
    
}