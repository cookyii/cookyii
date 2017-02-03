<?php
/**
 * _layout.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var string $content
 */

use cookyii\Facade as F;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

$this->beginPage();

backend\assets\AppAsset::register($this);

$title = empty($this->title)
    ? APP_NAME
    : Html::encode($this->title) . ' ~ ' . APP_NAME;

/** @var \backend\components\Controller $controller */
$controller = $this->context;

$Account = F::Account();

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()], 'canonical');

$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'], 'viewport');
if (!F::User()->isGuest) {
    $this->registerMetaTag(['name' => 'token', 'content' => $Account->token], 'token');
}

rmrevin\yii\favicon\Favicon::widget([
    'forceGenerate' => true,
    'appname' => 'Cookyii CMF',
    'color' => '#2B5797',
    'fillColor' => '#A4EDFF',
]);

$this->beginPage();

?><!DOCTYPE html>
<html <?= Html::renderTagAttributes([
    'lang' => Yii::$app->language,
    'ng-app' => 'BackendApp',
]) ?>>
<head>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

    <?php

    echo Html::csrfMetaTags();
    echo Html::tag('title', $title);

    $this->head();

    ?>
</head>
<body class="layout-boxed sidebar-mini skin-red skin-cookyii">
<?php

$this->beginBody();

if ($controller->loader === true) {
    echo Html::tag('div', FA::icon('cog')->spin(), [
        'id' => 'global-loader',
        'class' => 'loader-layout flex-center',
    ]);
}

?>
<div class="wrapper">
    <?= $content ?>
</div>
<?php

$this->endBody();

echo $this->render('_toast');

?>

</body>
</html><?php

$this->endPage();
