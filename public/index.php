<?php

use yii\helpers\ArrayHelper;

//define('YII_ENV', 'prod');

defined('MAINTENANCE_MODE') or define('MAINTENANCE_MODE', false);

defined('YII_ENV')
or define('YII_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'prod'));

//maintenance
if (MAINTENANCE_MODE) {
    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');
    header('Retry-After: 3600');

    echo '<html><body>
    <div style="text-align: center">
    <h1>Temporarily Down For Maintenance</h1>
    <p>We are performing scheduled maintenance. We should be back online shortly.</p></div>
    </body></html>';
    exit;
}

$dir = __DIR__ . '/../application';

//load env cobfig before yii including!
if('prod'!=YII_ENV) {
    $configEnv = require($dir . '/config/' . YII_ENV . '.php');
}

require($dir . '/vendor/autoload.php');
require($dir . '/vendor/yiisoft/yii2/Yii.php');

$config = require($dir . '/config/web.php');

if('prod'!=YII_ENV) {
    $config = ArrayHelper::merge($config, $configEnv);
} else {
    $config['components']['assetManager']['bundles'] = require($dir . '/assets/CompressedConfig.php');
}

(new yii\web\Application($config))->run();