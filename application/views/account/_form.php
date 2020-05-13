<?php
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use app\models\Image;

$form = ActiveForm::begin([
    'id' => 'user-form',
    'options' => [
        'enableAjaxValidation' => true,
        'enctype' => 'multipart/form-data'
    ],
]); ?>

<?= $form->field($model, 'email')->label('Email') ?>
<?= $form->field($model, 'name')->label('Name') ?>
<?= $form->field($model, 'site')->label('Website') ?>

<?php if ($model->idavatar): ?>
    <div class="controls">
        <?= Html::img(Image::url($model->idavatar, '/size/xsmall', '/images/avatar-empty.png')) ?>
    </div>
<?php endif ?>
<?= $form->field($model, 'avatar')->fileInput()->hint('Max size 700k. JPG, GIF, PNG.')->label('Avatar'); ?>

<div class="form-actions">
    <?= Html::submitButton('Save', ['class'=>'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
