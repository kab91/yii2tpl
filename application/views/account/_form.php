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

<?php echo $form->field($model, 'email')->label(Yii::t('app', 'Email')) ?>
<?php echo $form->field($model, 'name')->label(Yii::t('app', 'Name')) ?>
<?php echo $form->field($model, 'site')->label(Yii::t('app', 'Website')) ?>

<?php if ($model->idavatar): ?>
    <div class="controls">
        <img src="<?php echo Image::url($model->idavatar, '/size/xsmall', '/images/avatar-empty.png'); ?>"/>
    </div>
<?php endif ?>
<?php echo $form->field($model, 'avatar')->fileInput()->hint(Yii::t('app', 'Max size') . ' 700k. JPG, GIF, PNG.')->label(Yii::t('app', 'Avatar')); ?>

<div class="form-actions">
    <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class'=>'btn btn-primary']); ?>
</div>

<?php ActiveForm::end(); ?>
