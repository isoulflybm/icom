<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    'websocketServer' => [
        'host' => env('WEBSOCKETSERVER_HOST', 'localhost'),
        'port' => env('WEBSOCKETSERVER_PORT', 8000),
        'isSecure' => env('WEBSOCKETSERVER_ISSECURE', false),
        'localCert' => env('WEBSOCKETSERVER_LOCALCERT', null),
        'localPk' => env('WEBSOCKETSERVER_LOCALPK', null),
    ],
];
