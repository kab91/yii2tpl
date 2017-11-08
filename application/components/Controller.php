<?php
namespace app\components;


class Controller extends \yii\web\Controller
{
    public function init()
    {
        parent::init();
        mb_internal_encoding('utf-8');
    }
} 