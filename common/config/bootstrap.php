<?php
/**
 * bootstrap.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

$base = realpath(__DIR__ . '/../..');

Yii::setAlias('base', $base);
Yii::setAlias('messages', '@base/messages');
Yii::setAlias('node', '@base/node_modules');
Yii::setAlias('resources', '@base/resources');
Yii::setAlias('upload', '@base/upload');

Yii::setAlias('console', '@base/console-app');

Yii::setAlias('common', '@base/common');
Yii::setAlias('common/assets', '@base/common-assets');

Yii::setAlias('frontend', '@base/frontend-app');
Yii::setAlias('frontend/assets', '@base/frontend-assets');
Yii::setAlias('frontend/modules', '@base/frontend-modules');

Yii::setAlias('backend', '@base/backend-app');
Yii::setAlias('backend/assets', '@base/backend-assets');
Yii::setAlias('backend/modules', '@base/backend-modules');
