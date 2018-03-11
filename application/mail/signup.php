<?php
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\User $user;
 * @var string $password
 */
?>

<p>Hello!</p>
<p>Thank you for signing up in <?= Yii::$app->name ?>.</p>

<p>Use these credentials for log in:</p>
<p>
    <strong>Email:</strong> <?= Html::encode($user->email) ?><br>
    <strong>Password:</strong> <?=$password?>
</p>
<p>
    <a href="http://<?=\Yii::$app->params['domain']?>/account/login">Login</a>
</p>
