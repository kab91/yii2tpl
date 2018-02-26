<?php

namespace app\modules\admin\components;

use yii\filters\AccessControl;
use yii\web\Controller;

class AdminController extends Controller
{
	public $layout = 'main';

    public function init() {
        parent::init();
        mb_internal_encoding('utf-8');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
}
