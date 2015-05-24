<?php
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\User $user;
 */
?>

<p>Здравствуйте!</p>
<p>Поздравляем с регистрацией в системе <?=Yii::$app->name?>.</p>

<p>Для входа на сайт используйте следующие данные:</p>
<p>
    <strong>Email:</strong> <?=Html::encode($user->email)?><br>
    <strong>Пароль:</strong> <?=$password?>
</p>
<p>
    <a href="http://<?=\Yii::$app->params['domain']?>/account/login">Войти на сайт</a>
</p>
