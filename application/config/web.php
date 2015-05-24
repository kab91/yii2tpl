<?php

$dir = dirname(__DIR__);

return [
    'id' => 'yii2tpl',
    'name' => 'Yii2 TPL',
    'basePath' => $dir,
    'extensions' => require($dir . '/vendor/yiisoft/extensions.php'),
    'language' => 'en',
    'sourceLanguage' => 'en',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '6YE1aewrw@345345ABm5Z&it@',
        ],
        'cache' => [
            /*'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                ],
            ],*/
            'class' => 'yii\caching\FileCache',
        ],
        'imagesCache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'name' => 'xsid',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/account/login'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                'page/<slug:\w+>' => 'page/view',
                'image/<id:\d+>-<size:\w+>-<rev:\d+>.jpg' => 'image/get',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',

            ]
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2tpl',
            'tablePrefix' => 'x_',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user'],
        ],
    ],
    'params' => [
        'domain' => 'example.com',
        'staticUrl' => '',
        'socialLoginEnabled' => true,
        'images' => [
            //'secret' => 'dfr467623rfgt6u32rsd',
            'storagePath' => __DIR__ . '/../data/storage',
        ],
        'fromEmail' => 'support@example.com',
        'adminEmail' => 'admin@example.com',
        'supportEmail' => 'admin@example.com',
        'supportName' => 'example.com support',
        'user.passwordResetTokenExpire' => 3600,
    ],
];