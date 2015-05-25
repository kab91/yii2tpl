<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?= Yii::t('app', 'If you forgot your password you can <a href="{url}">reset it</a>.', ['url' => Url::to(['account/request-password-reset'])]) ?>
            </div>
            <div style="color:#999;margin:1em 0">
                <?= Yii::t('app', 'If you don\'t have account yet, please <a href="{url}">signup</a>.', ['url' => Url::to(['account/signup'])]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <?php if (true === \Yii::$app->params['socialLoginEnabled']): ?>
            <div class="col-lg-2">
                <span style="font-size: 14pt; padding:30px 30px 0 45px;color: #666"><?= Yii::t('app', 'or') ?></span>
            </div>
            <div class="col-lg-5">
                <script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
                <iframe
                    src="http://loginza.ru/api/widget?overlay=loginza&amp;providers_set=vkontakte,facebook,google,twitter,mailruapi,odnoklassniki,rambler,livejournal,openid&amp;token_url=<?php echo urlencode('http://' . \Yii::$app->params['domain'] . '/account/auth?token=' . \Yii::$app->request->csrfToken) ?>"
                    style="width:359px;height:170px;margin-top: -20px" scrolling="no" frameborder="no"></iframe>

            </div>
        <?php endif ?>
    </div>
</div>