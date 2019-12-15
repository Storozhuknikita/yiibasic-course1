<?php

$configFile = __DIR__ . '/data1.php';
$paramsFile = require __DIR__ . '/params.php';

$dataFile = [];
if ( file_exists($configFile) ) {
    $dataFile = require $configFile;
}

$params = array_merge( $paramsFile, $dataFile );

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    // календарь
    'defaultRoute' => ['user/calendar'],
    // а это на случай технических работ
    //'catchAll' => ['site/about'],
    /*
     * Add modules
     */
    'modules' => [
        'admin' => [
            'class' => \app\modules\admin\Module::class
        ],
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lKTfD3HzymW1A94kaQmWHRUqS_rgRgUe',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        // не удалось запустить у себя
        /*'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211
                ],
            ],
        ],*/

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false, // true если локально
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',
                'username' => $params['senderEmail'],
                'password' => $params['senderPassword'],
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => '/user/calendar',
                '<action:(about|contact|login)>' => 'site/<action>', // скрывает /site
                //'calendar/<ids:\d+>' => 'calendar/view' // подставлять id
            ],
        ],
        /*
         * Add component
         */
        'comp' => [
            'class' => \app\components\Comp::class,
        ],
        /*
         * Роли для пользователей
         */
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],

        /**
         * Настройки для даты
         */
        'formatter' => [
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'GMT+3',
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
        ],
    ],


    'params' => $params,
];


if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
