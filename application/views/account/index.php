<?php
/**
 * @var yii\web\View $this
 */
use app\models\Image;
use yii\helpers\Html;
$this->title = 'Профиль';
?>

<fieldset>
    <legend>Профиль</legend>

    <div class="row">
        <div class="col-lg-2">
            <div>
                <img src="<?php echo Image::url($user->idavatar, '/size/small', '/i/avatar-empty.png'); ?>"/>
            </div>
        </div>
        <div class="col-lg-10">
            <?php if ($user->fromSocial()): ?>
                <p>Соц.сеть: <?php echo Html::encode($user->identity) ?></p>
            <?php endif ?>

            <?php if ($user->email): ?>
                <p>Эл. почта: <a
                        href="mailto:<?php echo Html::encode($user->email) ?>"><?php echo Html::encode($user->email) ?></a>
                </p>
            <?php endif ?>

            <p>Имя: <?php echo Html::encode($user->name) ?></p>

            <?php if ($user->site): ?>
                <p>Веб-сайт: <a href="<?php echo Html::encode($user->site) ?>"
                                target="_blank"><?php echo Html::encode($user->site) ?></a></p>
            <?php endif ?>
            <p>Действия:</p>
            <ul>
                <li><a href="/account/update">Редактировать личную информацию</a></li>
                <?php if (!$user->fromSocial()): ?>
                    <li><a href="/account/password">Изменить пароль</a></li>
                <?php endif ?>
            </ul>
        </div>
    </div>

</fieldset>