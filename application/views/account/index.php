<?php
use app\models\Image;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var \app\models\User $user
 */

$this->title = 'Account';
?>

<fieldset>
    <legend><?= $this->title ?></legend>

    <div class="row">
        <div class="col-xs-3 col-sm-2">
            <?= Html::img(Image::url($user->idavatar, '/size/small', '/i/avatar-empty.png'), ['class' => 'img-responsive']) ?>
        </div>
        <div class="col-xs-9 col-sm-10">
            <?php if ($user->fromSocial()): ?>
                <p>Social: <?= Html::encode($user->identity) ?></p>
            <?php endif ?>

            <?php if ($user->email): ?>
                <p>Email:
                    <a href="mailto:<?= Html::encode($user->email) ?>"><?= Html::encode($user->email) ?></a>
                </p>
            <?php endif ?>

            <p>Name: <?= Html::encode($user->name) ?></p>

            <?php if ($user->site): ?>
                <p>
                    Website: <?= Html::a(Html::encode($user->site), Html::encode($user->site), ['target' => '_blank']) ?>
                </p>
            <?php endif ?>

            <?= Html::a('Edit user information', Url::to(['/account/update']), ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Change password', Url::to(['/account/password']), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

</fieldset>