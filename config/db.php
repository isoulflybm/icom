<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=' . env('MYSQL_DATABASE', 'icom'),
    'username' => env('MYSQL_USER', 'icom'),
    'password' => env('MYSQL_PASSWORD', 'Dsiujhjl2014'),
    'charset' => env('MYSQL_CHARSET', 'utf8'),

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
