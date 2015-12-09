<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var app\models\Page $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerJsFile('/js/bootstrap-maxlength.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile('/js/speakingurl.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile('/js/slugify.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJs("
    $('textarea.seo').maxlength({
        alwaysShow: true,
        threshold: 30,
        warningClass: 'label label-success',
        limitReachedClass: 'label label-important',
        separator: ' of ',
        preText: 'You have ',
        postText: ' chars remaining.'
    });

    $('#page-slug').slugify('#page-title');
", $this::POS_END);
?>

<div class="page-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'content')->widget(vova07\imperavi\Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 300,
                'imageUpload' => \yii\helpers\Url::to(['/image/upload']),
                'uploadImageFields' => [
                    Yii::$app->request->csrfParam => Yii::$app->request->getCsrfToken()
                ],
                'imageUploadCallback' => new JsExpression('admin.imageUpload'),
                'imageUploadErrorCallback' => new JsExpression('admin.imageUploadError'),
                'plugins' => [
                    'video'
                ]
            ]
        ]); ?>

        <?= $form->field($model, 'seo_keywords')->textarea(['class' => 'form-control seo', 'rows' => 4, 'maxlength' => 250]) ?>
        <?= $form->field($model, 'seo_description')->textarea(['class' => 'form-control seo', 'rows' => 3, 'maxlength' => 160]) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
