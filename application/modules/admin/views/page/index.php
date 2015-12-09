<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\PageSearch $searchModel
 */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
            [
                'class' => \yii\grid\DataColumn::className(),
                'attribute' => 'id',
                'headerOptions' => [
                    'style' => 'width: 50px'
                ]
            ],
			[
                'attribute' => 'slug',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::a($data->slug, $data->getUrl());
                }
            ],
			'title',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>

</div>
