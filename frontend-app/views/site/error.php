<?php
/**
 * error.php
 * @author Revin Roman
 *
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

use yii\helpers\Html;
use yii\web\HttpException;

frontend\_assets\AppAsset::register($this);

/** @var \frontend\controllers\SiteController $controller */
$controller = $this->context;

$controller->layout = '//wide';

$title = $label = Yii::t('app', 'Error');
$label_options = [];
if ($exception instanceof HttpException) {
    $title = $label = Yii::t('app', 'Error {number}', ['number' => $exception->statusCode]);
    Html::addCssClass($label_options, 'code');
}

$this->title = $title;

?>

<style>
    .error-panel {
        margin-top: -100px;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 100px 150px;
        text-align: center;
        color: #000000;
    }
    .error-panel p.text { font-size: 2em; }
    .error-panel p.text.small { font-size: 1.5em; }
    .error-panel a.back { font-size: 1.2em; }
</style>

<div layout="row" layout-align="center center" style="height: 100%">
    <div class="error-panel">
        <?php

        echo Html::tag('h1', $label, $label_options);

        if (!empty($message)) {
            echo Html::tag('p', nl2br(Html::encode($message)), ['class' => 'text']);
        }

        $message = $exception->getMessage();
        if (isset($_GET['vvv']) && !empty($message)) {
            echo Html::tag('p', nl2br(Html::encode($exception->getMessage())), ['class' => 'text small']);
        }
        ?>
        <br>

        <?= Html::a(Yii::t('app', 'Вернуться на главную'), ['/'], ['class' => 'back']) ?>
    </div>
</div>