<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Account Edit';
?>

<fieldset>
    <legend><?= $this->title ?></legend>
    <?= $this->render('_form', ['model'=>$model,]); ?>
</fieldset>