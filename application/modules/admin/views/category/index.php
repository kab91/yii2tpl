<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\CategorySearch $searchModel
 */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'layout' => '{items}',
		'columns' => [
            [
                'class' => \yii\grid\DataColumn::class,
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 50px'
                ]
            ],

            [
                'class' => \yii\grid\DataColumn::class,
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                        return '<span style="display:inline-block;width:'.(($model->level)*20).'px"></span>'.(Html::encode($model->name));
                    },
            ],

            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{up} {down} {create} {view} {update} {delete}',
                'buttons' => [
                    'create' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                                'title' => 'Add child',
                            ]);
                        },
                    'up' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, [
                                'title' =>'Move up',
                            ]);
                        },
                    'down' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, [
                            'title' => 'Move down',
                        ]);
                    },
                ]
            ],
		],
	]); ?>

</div>
