<?php
/**
 * @var yii\web\View $this
 */
use app\models\Image;
use yii\helpers\Html;
$this->title = Yii::t('app', 'Account');
?>

<fieldset>
    <legend><?= Yii::t('app', 'Account') ?></legend>

    <div class="row">
        <div class="col-lg-2">
            <div>
                <img src="<?php echo Image::url($user->idavatar, '/size/small', '/i/avatar-empty.png'); ?>"/>
            </div>
        </div>
        <div class="col-lg-10">
            <?php if ($user->fromSocial()): ?>
                <p><?= Yii::t('app', 'Social') ?>: <?php echo Html::encode($user->identity) ?></p>
            <?php endif ?>

            <?php if ($user->email): ?>
                <p><?= Yii::t('app', 'Email') ?>:
                    <a href="mailto:<?php echo Html::encode($user->email) ?>"><?php echo Html::encode($user->email) ?></a>
                </p>
            <?php endif ?>

            <p><?= Yii::t('app', 'Name') ?>: <?php echo Html::encode($user->name) ?></p>

            <?php if ($user->site): ?>
                <p><?= Yii::t('app', 'Website') ?>: <a href="<?php echo Html::encode($user->site) ?>"
                                target="_blank"><?php echo Html::encode($user->site) ?></a></p>
            <?php endif ?>

            <?= Html::a(Yii::t('app', 'Edit user information'), '/account/update', ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Change password'), '/account/password', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

</fieldset>