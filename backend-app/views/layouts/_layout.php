<?php
/**
 * _layout.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;

$this->beginPage();

backend\assets\AppAsset::register($this);

$title = empty($this->title)
    ? APP_NAME
    : Html::encode($this->title) . ' ~ ' . APP_NAME;

/** @var \backend\components\Controller $controller */
$controller = $this->context;

/** @var \resources\Account|null $User */
$User = User()->identity;

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()]);

$this->registerLinkTag([
    'rel' => 'stylesheet',
    'href' => '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&subset=latin,cyrillic'
]);

$this->beginPage();

?><!DOCTYPE html>
<html <?= Html::renderTagAttributes([
    'lang' => Yii::$app->language,
    'ng-app' => 'BackendApp',
]) ?>>
<head>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <?php

    echo Html::csrfMetaTags();
    echo Html::tag('title', $title);

    echo Html::tag('meta', '', ['charset' => Yii::$app->charset]);
    if (!User()->isGuest) {
        echo Html::tag('meta', null, ['name' => 'token', 'content' => $User->token]) . "\n";
    }

    $this->head();

    echo rmrevin\yii\favicon\Favicon::widget([
        'forceGenerate' => true,
        'appname' => 'Cookyii CMF',
        'color' => '#2B5797',
        'fillColor' => '#A4EDFF',
    ]);

    ?>
</head>
<body class="sidebar-mini skin-cookyii fixed">
<?php

$this->beginBody();

if ($controller->loader === true) {
    echo Html::tag('div', '<md-progress-circular class="md-warn md-hue-3" md-mode="indeterminate"></md-progress-circular>', [
        'id' => 'global-loader',
        'class' => 'loader-layout',
        'layout' => 'row',
        'layout-align' => 'center center',
    ]);
}

?>
<div class="wrapper">
    <?php
    echo $content;
    ?>
</div>
<?php

$this->endBody();

echo $this->render('_toast');

?>

</body>
</html><?php

$this->endPage();