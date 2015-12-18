<?php
/**
 * _toast.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

use rmrevin\yii\fontawesome\FA;

?>

<script type="text/ng-template" id="directives/progressbar/progressbar.html">
    <div class="toast-progress"></div>
</script>

<script type="text/ng-template" id="directives/toast/toast.html">
    <div class="{{ toastClass }} {{ toastType }} wo-animate animated flipInX" ng-click="tapToast()">
        <div class="icon">
            <div ng-switch on="toastType">
                <?
                echo FA::icon('times', ['ng-switch-when' => 'error'])->fixedWidth();
                echo FA::icon('exclamation-triangle', ['ng-switch-when' => 'warning'])->fixedWidth();
                echo FA::icon('check', ['ng-switch-when' => 'success'])->fixedWidth();
                echo FA::icon('info', ['ng-switch-when' => 'info'])->fixedWidth();
                ?>
            </div>
        </div>
        <div class="body" ng-switch on="allowHtml">
            <div ng-switch-default ng-if="title" class="{{ titleClass }}" aria-label="{{ title }}" ng-bind="title"></div>
            <div ng-switch-default class="{{ messageClass }}" aria-label="{{ message }}" ng-bind="message"></div>
            <div ng-switch-when="true" ng-if="title" class="{{ titleClass }}" ng-bind-html="title"></div>
            <div ng-switch-when="true" class="{{ messageClass }}" ng-bind-html="message"></div>
        </div>
        <progress-bar ng-if="progressBar"></progress-bar>
    </div>
</script>
