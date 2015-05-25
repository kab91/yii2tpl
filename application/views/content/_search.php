<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\ContentSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="content-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'iduser') ?>

		<?= $form->field($model, 'idtitleimage') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'lead') ?>

		<?php // echo $form->field($model, 'body') ?>

		<?php // echo $form->field($model, 'is_published') ?>

		<?php // echo $form->field($model, 'publish_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<div class="form-group">
			<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>