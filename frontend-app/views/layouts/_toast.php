<?php
/**
 * _toast.php
 * @author Revin Roman
 */

use rmrevin\yii\fontawesome\FA;

?>

<script type="text/ng-template" id="toast-info.html">
    <md-toast class="info">
        <span flex>
            <?= FA::icon('info')->fixedWidth() ?>
            <strong ng-show="false">{{ message.title }}<br></strong>
            <span>{{ message.text }}</span>
        </span>
        <md-button ng-click="resolve()" class="md-action">
            {{ action }}
        </md-button>
    </md-toast>
</script>

<script type="text/ng-template" id="toast-success.html">
    <md-toast class="success">
        <span flex>
            <?= FA::icon('check')->fixedWidth() ?>
            <strong ng-show="false">{{ message.title }}<br></strong>
            <span>{{ message.text }}</span>
        </span>
        <md-button ng-click="resolve()" class="md-action">
            {{ action }}
        </md-button>
    </md-toast>
</script>

<script type="text/ng-template" id="toast-warning.html">
    <md-toast class="warning">
        <span flex>
            <?= FA::icon('exclamation-triangle')->fixedWidth() ?>
            <strong ng-show="false">{{ message.title }}<br></strong>
            <span>{{ message.text }}</span>
        </span>
        <md-button ng-click="resolve()" class="md-action">
            {{ action }}
        </md-button>
    </md-toast>
</script>

<script type="text/ng-template" id="toast-danger.html">
    <md-toast class="danger">
        <span flex>
            <?= FA::icon('times')->fixedWidth() ?>
            <strong ng-show="false">{{ message.title }}<br></strong>
            <span>{{ message.text }}</span>
        </span>
        <md-button ng-click="resolve()" class="md-action">
            {{ action }}
        </md-button>
    </md-toast>
</script>