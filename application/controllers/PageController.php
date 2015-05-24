<?php

namespace app\controllers;

use app\models\Page;
use yii\web\NotFoundHttpException;
use app\components\Controller;

class PageController extends Controller
{
	public function actionView($slug)
	{
        $page = Page::findOne(['slug' => $slug]);
        if(!$page)
            throw new NotFoundHttpException('page not found');

        $this->view->title = $page->title;
        return $this->render('view', ['title' => $page->title, 'content' => $page->content]);
    }

}
