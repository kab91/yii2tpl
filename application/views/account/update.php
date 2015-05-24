<?php
/**
 * @var yii\web\View $this
 */
$this->title = 'Редактирование профиля';
?>

<fieldset>
    <legend>Редактирование профиля</legend>
    <?php echo $this->render('_form', ['model'=>$model,]); ?>
</fieldset>