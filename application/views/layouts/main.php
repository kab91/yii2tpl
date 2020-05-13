<?php
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use app\components\Alert;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    $user = app\models\User::findIdentity(Yii::$app->user->id);

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [

            'class' => 'navbar-dark bg-dark navbar-expand-md fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index'], 'visible' => Yii::$app->controller->action->getUniqueId() !== 'site/index'],
            ['label' => 'About', 'url' => ['/page/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'Manage', 'url' => ['/admin'], 'visible' => Yii::$app->user->can('admin')],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/account/login']] : '',

            Yii::$app->user->isGuest ? '' :
                ['label' => Yii::$app->user->identity->name,

                    'items' => [
                        ['label' => 'Account', 'url' => ['/account']],
                        ['label' => 'Logout',
                            'url' => ['/account/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                    ]
                ]
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
