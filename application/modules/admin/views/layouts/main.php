<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= Html::encode($this->title) ?></title>
    <?=Html::csrfMetaTags()?>
	<?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
	<div class="wrap">
		<?php
			NavBar::begin([
				'brandLabel' => Yii::t('app', 'Control Panel'),
				'brandUrl' => Yii::$app->homeUrl,
				'options' => [
					'class' => 'navbar-inverse navbar-fixed-top',
				],
			]);
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav'],
				'items' => [
					['label' => Yii::t('app', 'Categories'), 'url' => ['/admin/category']],
					['label' => Yii::t('app', 'Pages'), 'url' => ['/admin/page']],
					['label' => Yii::t('app', 'Back to website'), 'url' => ['/']],
					Yii::$app->user->isGuest ?
						['label' => 'Login', 'url' => ['/site/login']] :
						['label' => 'Logout (' . Yii::$app->user->identity->name . ')' ,
							'url' => ['/account/logout'],
							'linkOptions' => ['data-method' => 'post']],
				],
			]);
			NavBar::end();
		?>

		<div class="container">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= $content ?>
		</div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; My Company <?= date('Y') ?></p>
			<p class="pull-right"><?= Yii::powered() ?></p>
		</div>
	</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>