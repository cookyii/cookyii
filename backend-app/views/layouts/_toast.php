<?php
/**
 * _toast.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

use rmrevin\yii\fontawesome\FA;

?>

<script type="text/ng-template" id="toast-info.html">
    <md-toast class="info">
        <span flex>
            <?= FA::icon('info')->fixedWidth() ?>
            <span>{{ message }}</span>
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
            <span>{{ message }}</span>
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
            <span>{{ message }}</span>
        </span>
        <md-button ng-click="resolve()" class="md-action">
            {{ action }}
        </md-button>
    </md-toast>
</script>

<script type="text/ng-template" id="toast-error.html">
    <md-toast class="danger">
        <span flex>
            <?= FA::icon('times')->fixedWidth() ?>
            <span>{{ message }}</span>
        </span>
        <md-button ng-click="resolve()" class="md-action">
            {{ action }}
        </md-button>
    </md-toast>
</script>