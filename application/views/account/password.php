<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\User $model
 */
$this->title = Yii::t('app','Изменение пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
	<h1><?= Html::encode($this->title) ?></h1>

	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'password-form']); ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'newpassword')->widget(PasswordInput::classname()) ?>
				<div class="form-group">
					<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
