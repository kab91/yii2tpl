<?php

namespace app\controllers;

use Yii;
use app\components\Controller;

class UtilsController extends Controller
{
    public function actionFlush()
    {
        Yii::$app->cache->flush();
        if (Yii::$app->imagesCache)
            Yii::$app->imagesCache->flush();
        $this->redirect('/');
    }
}