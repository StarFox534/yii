<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=printer_bd',
    'username' => 'admin',
    'password' => 'admin',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',

    // turn on schema caching to improve performance
    'schemaCache' => 'db_cache', // Какой движок будет кешировать
    'schemaCacheDuration' => 3600, // Время кеширования
    'enableSchemaCache' => true, // Включаем кеширование схемы таблиц бд
];
