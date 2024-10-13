<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

use Workerman\Worker;

class WebsocketServerController extends Controller
{
    public function actionIndex()
    {
        $ws_worker = null;
        
        if(Yii::$app->params['websocketServer']['isSecure']) {
            // SSL context.
            $context = [
                'ssl' => [
                    'local_cert'  => Yii::$app->params['websocketServer']['localCert'],
                    'local_pk'    => Yii::$app->params['websocketServer']['localPk'],
                    'verify_peer' => false,
                ]
            ];
    
            // Create a Websocket server with ssl context.
            $ws_worker = new Worker(
                'websocket://'
                . Yii::$app->params['websocketServer']['host']
                . ':'
                . Yii::$app->params['websocketServer']['port'],
                $context
            );
            
            // Enable SSL. WebSocket+SSL means that Secure WebSocket (wss://). 
            // The similar approaches for Https etc.
            $ws_worker->transport = 'ssl';
        }
        else {
            // Create a Worker to listen on port 2345 and use the websocket protocol
            $ws_worker = new Worker(
                'websocket://'
                . Yii::$app->params['websocketServer']['host']
                . ':'
                . Yii::$app->params['websocketServer']['port']
            );
        }

        if($ws_worker) {
            $ws_worker->onMessage = function ($connection, $data) use ($ws_worker) {
                // Send $data
                foreach($ws_worker->connections as $connection) {
                    $connection->send($data);
                }
            };
            Worker::runAll();
        }
        
        return ExitCode::OK;
    }

}
