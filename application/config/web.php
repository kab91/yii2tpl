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
    'bootstrap' => ['log', 'assetsAutoCompress'],
    'components' => [
        'assetsAutoCompress' => [
            'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled' => true,
        ],
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
            'class' => 'yashop\ses\Mailer',
            'access_key' => 'ACCESS_KEY',
            'secret_key' => 'SECRET_KEY',
            'host' => 'AWS_HOST',
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                'file' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                    'logVars' => ['_GET', '_POST', '_SESSION', '_COOKIE'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require_once 'urls.php'
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => require_once 'params.php'
];