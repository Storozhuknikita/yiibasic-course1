<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=yii2basic',
    'username' => 'root',
    'password' => 'root',
    //'dsn' => 'mysql:host=mysql.istsam.myjino.ru;dbname=istsam_tt',
    //'username' => '045539147_tt',
    //'password' => 'd2z-onY-zeH-2rv',
    'charset' => 'utf8',
    //'tablePrefix' => 'yii2_',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
