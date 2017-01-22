<?php
/**
 * _layout.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var string $content
 */

use cookyii\Decorator as D;
use yii\helpers\Html;

$this->beginPage();

frontend\assets\AppAsset::register($this);

$title = empty($this->title)
    ? APP_NAME
    : Html::encode($this->title) . ' ~ ' . APP_NAME;

/** @var \frontend\components\Controller $controller */
$controller = $this->context;

/** @var \resources\Account\Model|null $Account */
$Account = D::User()->identity;

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()], 'canonical');

$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'], 'viewport');
if (!D::User()->isGuest) {
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
    'ng-app' => 'FrontendApp',
]) ?>>
<head>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <?php

    echo Html::csrfMetaTags();
    echo Html::tag('title', $title);

    $this->head();

    ?>
</head>
<body>
<?php

$this->beginBody();

echo $content;

$this->endBody();

echo $this->render('_toast');
echo $this->render('_analytics');

?>

</body>
</html><?php

$this->endPage();
