<?php
/**
 * wide.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 *
 * @var yii\web\View $this
 * @var string $content
 */

$this->beginContent('@app/views/layouts/_layout.php', ['content' => $content]);

echo $content;

$this->endContent();