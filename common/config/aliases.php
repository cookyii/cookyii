<?php

$base = realpath(__DIR__ . '/../..');

Yii::setAlias('base', $base);
Yii::setAlias('components', '@base/components');
Yii::setAlias('common', '@base/common');
Yii::setAlias('modules', '@base/modules');
Yii::setAlias('resources', '@base/resources');
Yii::setAlias('messages', '@base/messages');
Yii::setAlias('node', '@base/node_modules');

Yii::setAlias('frontend', '@base/frontend-app');
Yii::setAlias('frontend/modules', '@base/frontend-modules');

Yii::setAlias('backend', '@base/backend-app');
Yii::setAlias('backend/modules', '@base/backend-modules');
