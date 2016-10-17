<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\UserType;
use app\models\Image;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'roles')->checkboxList(User::getRolesList()) ?>
    <?php endif ?>

    <?php if ($model->idavatar): ?>
        <div class="controls">
            <img src="<?= Image::url($model->idavatar, '/size/xsmall', '/i/avatar-empty.png'); ?>"/>
        </div>
    <?php endif ?>
    <?= $form->field($model, 'avatar')->fileInput()->label(Yii::t('app', 'Avatar')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>