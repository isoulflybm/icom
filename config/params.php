<?php

return [
    'adminEmail' => 'smartnet-brovary@ukr.net',
    'senderEmail' => 'isoulfly.bm@gmail.com',
    'senderName' => 'Smartnet-Brovary',
    
    'websocketServer' => [
        'host' => env('WEBSOCKETSERVER_HOST', 'localhost'),
        'port' => env('WEBSOCKETSERVER_PORT', 8000),
        'isSecure' => env('WEBSOCKETSERVER_ISSECURE', false),
        'localCert' => env('WEBSOCKETSERVER_LOCALCERT', null),
        'localPk' => env('WEBSOCKETSERVER_LOCALPK', null),
    ],
];
