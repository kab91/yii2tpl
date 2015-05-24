<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Image;

$form = ActiveForm::begin([
    'id' => 'user-form',
    'options' => [
        'enableAjaxValidation' => true,
        'enctype' => 'multipart/form-data'
    ],
]); ?>

<?php echo $form->field($model, 'email')->label('E-mail') ?>
<?php echo $form->field($model, 'name')->label('Имя') ?>
<?php echo $form->field($model, 'site')->label('Сайт') ?>

<?php if ($model->idavatar): ?>
    <div class="controls">
        <img src="<?php echo Image::url($model->idavatar, '/size/xsmall', '/images/avatar-empty.png'); ?>"/>
    </div>
<?php endif ?>
<?php echo $form->field($model, 'avatar')->fileInput()->hint('Максимальный размер 700k. JPG, GIF, PNG.')->label('Аватар'); ?>

<div class="form-actions">
    <?php echo Html::submitButton('Сохранить', ['class'=>'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
