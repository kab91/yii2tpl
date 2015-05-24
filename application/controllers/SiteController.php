<?php
namespace app\controllers;

use Yii;
use app\components\Controller;
use app\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [

		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex()
	{
		return $this->render('index');
	}

    public function actionContact()
    {
        $model = new ContactForm;

        if (Yii::$app->user->isGuest) {
            $model->setScenario('guest');
        } else {
            $model->name = Yii::$app->user->getIdentity()->name;
            $model->email = Yii::$app->user->getIdentity()->email;
        }

        if ($model->load($_POST) && $model->contact(Yii::$app->params['supportEmail'])) {
            Yii::$app->session->setFlash(
                'success',
                'Thank you for contacting us. We will respond to you as soon as possible.'
            );
            return $this->goHome();
        } else {
            return $this->render(
                'contact',
                [
                    'model' => $model,
                ]
            );
        }
	}
}
