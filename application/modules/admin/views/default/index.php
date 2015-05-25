<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Yii::t('app', 'Manage Categories') ?></h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <p><?= Yii::t('app', 'Create, update, delete categories') ?></p>
                    <?= Html::a(Yii::t('app', 'Manage'), Url::to(['/admin/category']), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Yii::t('app', 'Manage Pages') ?></h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <p><?= Yii::t('app', 'Create, update, delete pages') ?></p>
                    <?= Html::a(Yii::t('app', 'Manage'), Url::to(['/admin/page']), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">

    </div>
    <div class="col-xs-3">

    </div>
</div>

