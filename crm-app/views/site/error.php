<?php
/**
 * error.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

use yii\helpers\Html;
use yii\web\HttpException;

crm\assets\AppAsset::register($this);

/** @var \crm\controllers\SiteController $controller */
$controller = $this->context;

$controller->layout = '//wide';

$title = $label = Yii::t('app', 'Error');
if ($exception instanceof HttpException) {
    $title = $label = Yii::t('app', 'Error {number}', ['number' => $exception->statusCode]);
}

$this->title = $title;

?>

<style>
    .wrapper { display: flex; align-items: center; justify-content: center; }
    .content-wrapper { margin-left: 0; min-height: initial; }
    .content-wrapper .content { padding: 90px 60px 90px; min-height: initial; }
    .content-wrapper .content .error-page { margin: 0; }
    .content-wrapper .content .error-page .error-content { margin-left: 0; }
    .content-wrapper .content .error-page .error-content h3 { margin-top: 0; }
</style>

<div class="content-wrapper">
    <section class="content">
        <div class="error-page">
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> <?= $label ?></h3>
                <?php
                if (!empty($message)) {
                    echo Html::tag('p', nl2br(Html::encode($message)), ['class' => 'text']);
                }

                $message = $exception->getMessage();
                if (isset($_GET['vvv']) && !empty($message)) {
                    echo Html::tag('p', nl2br(Html::encode($exception->getMessage())), ['class' => 'text small']);
                }
                ?>

                <p>
                    We will work on fixing that right away.
                    Meanwhile, you may <?= Html::a('return to dashboard', ['/']) ?>.
                </p>
            </div>
        </div>
    </section>
</div>