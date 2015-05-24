<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\Content $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="content-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'iduser')->textInput() ?>

		<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

		<?= $form->field($model, 'lead')->textInput(['maxlength' => 255]) ?>

		<?= $form->field($model, 'publish_at')->textInput() ?>

		<?= $form->field($model, 'created_at')->textInput() ?>

		<?= $form->field($model, 'idtitleimage')->textInput() ?>

		<?= $form->field($model, 'is_published')->checkbox() ?>

		<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

		<?= $form->field($model, 'updated_at')->textInput() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
