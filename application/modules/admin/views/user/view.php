<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Image;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'avatar',
                'format' => 'html',
                'value' => Html::img(Image::url($model->idavatar, ['size' => 'medium'], '/i/avatar-empty.png'))
            ],
            'name',
            'email:email',
            [
                'attribute' => 'created_at',
                'value' => date('d.n.Y @ H:i', $model->created_at)
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('d.n.Y @ H:i', $model->updated_at)
            ],
            [
                'attribute' => 'roles',
                'value' => $model->getRolesStr()
            ],
        ],
    ]) ?>

</div>
