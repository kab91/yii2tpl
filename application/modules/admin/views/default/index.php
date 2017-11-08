<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
?>

<div class="row">
    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Manage Categories</h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <p>Create, update, delete categories</p>
                    <?= Html::a('Manage', Url::to(['/admin/category']), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Manage Pages</h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <p>Create, update, delete pages</p>
                    <?= Html::a('Manage', Url::to(['/admin/page']), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Manage Users</h3>
            </div>
            <div class="panel-body">
                <div class="text-center">
                    <p>Create, update, delete users</p>
                    <?= Html::a('Manage', Url::to(['/admin/user']), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">

    </div>
</div>

