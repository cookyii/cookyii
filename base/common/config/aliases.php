<?php

$base = realpath(__DIR__ . '/../..');

Yii::setAlias('base', $base);
Yii::setAlias('common', '@base/common');
Yii::setAlias('environment', '@base/environments/' . YII_ENV);

Yii::setAlias('frontend', '@base/frontend-app');
Yii::setAlias('frontend/modules', '@base/frontend-modules');

Yii::setAlias('backend', '@base/backend-app');
Yii::setAlias('backend/modules', '@base/backend-modules');

Yii::setAlias('crm', '@base/crm-app');
Yii::setAlias('crm/modules', '@base/crm-modules');

Yii::setAlias('messages', '@base/messages');

Yii::setAlias('node', '@base/node_modules');