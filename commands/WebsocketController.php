<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Workerman\Worker;

class WebsocketController extends Controller
{
    // Port
    public $port = 8080;

    // SSL context.
    public $context = [
        'ssl' => [
            'local_cert'  => '/etc/apache2/certs/localhost.crt',
            'local_pk'    => '/etc/apache2/keys/localhost.key',
            'verify_peer' => false,
        ]
    ];
    
    public function options($actionID)
    {
        return ['port'];
    }
    
    public function actionServe()
    {
        print "Server started as {$this->port}";

        // Create a Websocket server
        $ws_worker = new Worker("websocket://0.0.0.0:{$this->port}", $this->context);

        // Enable SSL. WebSocket+SSL means that Secure WebSocket (wss://). 
        // The similar approaches for Https etc.
        $ws_worker->transport = 'ssl';
        
        // Emitted when new connection come
        $ws_worker->onConnect = function ($connection) {
            echo "New connection\n";
        };
        
        // Emitted when data received
        $ws_worker->onMessage = function ($connection, $data) {
            // Send hello $data
            $connection->send('Hello ' . $data);
        };
        
        // Emitted when connection closed
        $ws_worker->onClose = function ($connection) {
            echo "Connection closed\n";
        };
        
        // Run worker
        Worker::runAll();
        
        return ExitCode::OK;
    }

}
