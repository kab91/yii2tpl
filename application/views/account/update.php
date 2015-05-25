<?php
/**
 * @var yii\web\View $this
 */
$this->title = Yii::t('app', 'Account Edit');
?>

<fieldset>
    <legend><?= Yii::t('app', 'Account Edit') ?></legend>
    <?php echo $this->render('_form', ['model'=>$model,]); ?>
</fieldset>