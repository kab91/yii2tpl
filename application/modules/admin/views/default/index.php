<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard';
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Manage Categories</h5>
                <p class="card-text">Create, update, delete categories</p>
                <?= Html::a('Manage', Url::to(['/admin/category']), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Manage Pages</h5>
                <p class="card-text">Create, update, delete pages</p>
                <?= Html::a('Manage', Url::to(['/admin/page']), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Manage Users</h5>
                <p class="card-text">Create, update, delete users</p>
                <?= Html::a('Manage', Url::to(['/admin/user']), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>

