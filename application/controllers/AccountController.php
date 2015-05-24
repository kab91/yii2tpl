<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\HttpException;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\components\Controller;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\PasswordForm;
use app\models\User;
use app\models\Image;

class AccountController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signup', 'logout', 'index', 'update'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id === 'auth') {
            \Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionAuth()
    {

        if (true !== Yii::$app->params['socialLoginEnabled']) {
            throw new HttpException(404);
        }

        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $error = false;
        if (!isset($_GET['token'])) {
            $error = true;
        }

        if (!$error && isset($_POST['token'])) {
            $user = User::loginzaAuth($_POST['token']);
            if ($user) {
                $duration = 3600 * 24 * 30; // 30 days
                Yii::$app->user->login($user, $duration);
                $this->redirect(User::getRedirectUrl());
            } else {
                $error = true;
            }

        } else {
            $error = true;
        }

        if ($error) {
            Yii::$app->getSession()->setFlash('Авторизация не пройдена');
            $this->redirect('/account/login');
        }
    }

    public function actionUpdate()
    {
        $user = Yii::$app->user->getIdentity(); /* @var $user User */

        if ($user->load(Yii::$app->request->post())) {
            $user->avatar = UploadedFile::getInstance($user, 'avatar');

            if ($user->save()) {
                if ($user->avatar) {
                    $user->idavatar = Image::upload($user->idavatar, $user->avatar);
                    $user->save(false);
                }

                //BUG next line kill auth :(
                //Yii::$app->getSession()->setFlash('Профиль успешно обновлен!');
                $this->redirect('/account');
            }
        }

        return $this->render('update', array(
            'model' => $user,
        ));
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->getIdentity();
        return $this->render('index', ['user' => $user,]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionPassword()
    {
        $model = new PasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect('/account');
        } else {
            return $this->render('password', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->getSession()->setFlash('success', 'Мы отправили пароль для входа на адрес '.$model->email.' Проверьте почту, в т.ч. папку Спам.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
            return $this->goHome();
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
