<?php
/**
 * _layout.php
 * @author Revin Roman http://phptime.ru
 *
 * @var yii\web\View $this
 * @var string $content
 */

use yii\helpers\Html;

$this->beginPage();

backend\_assets\AppAsset::register($this);

$title = empty($this->title)
    ? APP_NAME
    : Html::encode($this->title) . ' ~ ' . APP_NAME;

/** @var \backend\components\Controller $controller */
$controller = $this->context;

/** @var User|null $User */
$User = User()->identity;

$this->registerLinkTag(['rel' => 'canonical', 'href' => \yii\helpers\Url::canonical()]);
$this->registerLinkTag(['rel' => 'shortcut icon', 'href' => '/favicon.ico']);
$this->registerLinkTag(['rel' => 'apple-touch-icon', 'href' => '/img/apple-touch-icon.png']);
$this->registerLinkTag(['rel' => 'apple-touch-icon', 'href' => '/img/apple-touch-icon-72x72.png']);
$this->registerLinkTag(['rel' => 'apple-touch-icon', 'href' => '/img/apple-touch-icon-114x114.png']);

$this->registerLinkTag([
    'rel' => 'stylesheet',
    'href' => '//fonts.googleapis.com/css?family=Open+Sans:200,400,700&subset=latin,cyrillic'
]);

$this->beginPage();

?><!DOCTYPE html>
<?= Html::beginTag('html', [
    'lang' => Yii::$app->language,
    'ng-app' => 'BackendApp',
]) ?>
<head>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?
    echo Html::csrfMetaTags();
    echo Html::tag('title', $title);

    echo Html::tag('meta', '', ['charset' => Yii::$app->charset]);
    if (!User()->isGuest) {
        echo Html::tag('meta', null, ['name' => 'token', 'content' => $User->token]) . "\n";
    }

    $this->head()
    ?>
</head>
<body>
<? $this->beginBody() ?>

<?

if ($controller->hideLoader === false) {
    echo Html::tag('div', '<md-progress-circular class="md-warn md-hue-3" md-mode="indeterminate"></md-progress-circular>', [
        'id' => 'global-loader',
        'class' => 'loader-layout',
        'layout' => 'row',
        'layout-align' => 'center center',
    ]);
}

echo $content;

$this->endBody();

echo $this->render('_toast');

?>

</body>
</html><?

$this->endPage();