<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var app\models\Page $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="page-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>
		<?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'content')->widget(yii\imperavi\Widget::className(),[
            'options' => [
                'minHeight' => '300',
                'imageUpload' => '/image/upload',
                'uploadFields' => [
                    Yii::$app->request->csrfParam => Yii::$app->request->getCsrfToken()
                ],
                'imageUploadCallback' => new JsExpression('admin.imageUpload'),
                'imageUploadErrorCallback' => new JsExpression('admin.imageUploadError'),
            ]
        ]) ?>


		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
