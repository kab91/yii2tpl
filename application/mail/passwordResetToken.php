<?php
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\User $user;
 */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['account/reset-password', 'token' => $user->password_reset_token]);
?>

Hello <?= Html::encode($user->name) ?>,

<?=Yii::t('app','Перейдите по ссылке, чтобы сбросить пароль:')?>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
