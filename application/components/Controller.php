<?php
namespace app\components;

use app\components\LanguageBehavior;

class Controller extends \yii\web\Controller {
    public function init() {
        parent::init();
        mb_internal_encoding('utf-8');

        \Yii::$app->on('beforeRequest',LanguageBehavior::handleLanguageBehavior());
    }
} 