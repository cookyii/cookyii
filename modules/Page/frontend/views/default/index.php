<?php
/**
 * index.php
 * @author Revin Roman
 * @link https://rmrevin.com
 *
 * @var yii\web\View $this
 * @var cookyii\modules\Page\resources\Page $Page
 */

use yii\helpers\Html;

$meta = $Page->meta();

$this->title = isset($meta['title'])
    ? $meta['title']
    : $Page->title;

if (isset($meta['keywords'])) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $meta['keywords']]);
}

if (isset($meta['description'])) {
    $this->registerMetaTag(['name' => 'description', 'content' => $meta['description']]);
}

?>

<section id="page-detail">
    <div class="row content">
        <div class="col-lg-12">
            <h3 class="dark1"><?= $Page->title ?></h3>
        </div>

        <div class="col-lg-12">
            <?= Html::tag(
                'div',
                $Page->content,
                ['class' => 'page-content']
            ) ?>
        </div>
    </div>
</section>