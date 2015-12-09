<?php

namespace app\controllers;

use app\models\Page;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use Yii;

class PageController extends Controller
{
	public function actionView($slug)
	{
        $model = Page::findOne(['slug' => $slug]);
        if (!$model) {
            throw new NotFoundHttpException('page not found');
        }

        $this->view->title = Yii::$app->name . ' – ' . $model->title;
        if ($model->seo_keywords) {
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $model->seo_keywords]);
        }
        if ($model->seo_description) {
            $this->view->registerMetaTag(['name' => 'description', 'content' => $model->seo_description]);
        }
        return $this->render('view', ['model' => $model]);
    }

}
