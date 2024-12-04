<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use kartik\sidenav\SideNav;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    
    $brandLabel = Yii::$app->name;
    $brandUrl = Yii::$app->homeUrl;
    if(!Yii::$app->user->isGuest) {
        $logourl = Yii::$app->user->identity->getUsersLogos()->orderBy('id DESC')->one();
        if($logourl) $brandLabel = "<img src='{$logourl->logo}' class='brand-logo'>";
        //$brandUrl = ["/user/settings"];
    }
    
    NavBar::begin([
        'brandLabel' => $brandLabel,
        'brandUrl' => $brandUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-dark bg-dark navbar-static-top'
        ]
    ]);
    
    $navbar_items = ['label' => '<li class="div">&nbsp;</li>'];
    if(Yii::$app->user->isGuest) {
        array_push($navbar_items, ['label' => 'Sign Up', 'url' => ["/user/register"]]);
        array_push($navbar_items, ['label' => 'Sign In', 'url' => ["/user/login"]]);
    }
    else {
        if(Yii::$app->user->identity->hasUsersPermission('admin_menu')) {
            array_push($navbar_items, ['label' => 'Admin', 'url' => ["/admin/index"]]);
        }
        array_push($navbar_items, ['label' => 'Create', 'url' => ["/feed/create"]]);
        array_push($navbar_items, ['label' => 'Settings', 'url' => ["/user/settings"]]);
        array_push($navbar_items, ['label' => 'Logout', 'url' => ["/user/logout"]]);
    };
    
    NavBar::end();
    
    echo Nav::widget([
        'options' => [
            'id' => 'w0-collapse',
            'class' => 'nav navbar-nav navbar-dark bg-dark navbar-right navbar-collapse collapse'
        ],
        'items' => $navbar_items
    ]);

    /*if(Yii::$app->user->identity->hasUsersPermission('admin_menu')) {
        NavBar::begin([
            'options' => [
                'class' => 'nav navbar-nav navbar-white navbar-expand navbar-static-top'
            ]
        ]);
        
        echo Nav::widget([
            'options' => [
                'id' => 'w1-collapse',
                'class' => 'nav navbar-nav navbar-white navbar-right'
            ],
            'items' => [
                //['label' => 'Entities', 'url' => ["/feed/entities"]],
            ]
        ]);
        
        NavBar::end();
    }*/
    
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Smartnet Brovary <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
