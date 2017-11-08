<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);

return [
    'bootstrap' => ['debug'],
    'components' => [
        'assetsAutoCompress' => [
            'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled' => false,
        ],
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=yii2tpl',
            'username' => 'root',
            'password' => '',
            'enableSchemaCache' => false,
        ],
        'log' => [
            'traceLevel' => 3,
            'targets' => [
                'file' => [
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'modules' => [
        'debug' => 'yii\debug\Module',
        'gii' => 'yii\gii\Module',
    ],
    'params' => [
        'domain' => 'yii2tpl.local',
    ]

];