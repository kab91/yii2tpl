<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Image;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'class' => \yii\grid\DataColumn::className(),
                'headerOptions' => [
                    'style' => 'width: 50px',
                ],
            ],
            [
                'attribute' => 'avatar',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img(Image::url($data->idavatar, ['size' => 'small'], '/i/avatar-empty.png'));
                }
            ],
            'name',
            'email:email',
            [
                'attribute' => 'created_at',
                'value' => function ($data) {
                    return date('d.n.Y @ H:i', $data->created_at);
                }
            ],
            [
                'attribute' => 'roles',
                'value' => function ($data) {
                    return $data->getRolesStr();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
