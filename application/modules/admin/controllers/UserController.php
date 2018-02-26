<?php

namespace app\modules\admin\controllers;

use app\models\AuthItem;
use app\models\Image;
use Yii;
use app\models\User;
use app\models\search\UserSearch;
use app\modules\admin\components\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AdminController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $password = Yii::$app->getSecurity()->generateRandomString(10);
            /** @var User $user */
            $model->setPassword($password);
            $model->generateAuthKey();

            $model->avatar = UploadedFile::getInstance($model, 'avatar');

            if ($model->save()) {
                if ($model->avatar) {
                    $model->idavatar = Image::upload($model->idavatar, $model->avatar);
                    $model->save(false);
                }

                Yii::$app->mail->compose('signup', ['user' => $model, 'password' => $password])
                    ->setTo($model->email)
                    ->setFrom(Yii::$app->params['supportEmail'], Yii::$app->params['supportName'])
                    ->setSubject('Sign up in Application')
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $rolesArr = Yii::$app->request->post()['User']['roles'];
            $roles = AuthItem::find()->where(['name' => $rolesArr])->all();

            $model->unlinkAll('roles', true);

            foreach ($roles as $role) {
                $model->link('roles', $role);
            }

            $model->avatar = UploadedFile::getInstance($model, 'avatar');

            if ($model->save()) {
                if ($model->avatar) {
                    $model->idavatar = Image::upload($model->idavatar, $model->avatar);
                    $model->save(false);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
