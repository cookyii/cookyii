(function (ng, $) {
  "use strict";

  ng.module('BackendApp', [
      'directives', 'filters', 'scopes',
      'ngCookies', 'ngSanitize', 'ngResource', 'ngAnimate',
      'ui.bootstrap', 'ui.uploader',
      'monospaced.elastic',
      'angular-loading-bar', 'angular-redactor'
    ])

    .config([
      '$httpProvider', '$animateProvider', 'redactorOptions', 'toastrConfig',
      function ($httpProvider, $animateProvider, redactorOptions, toastrConfig) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        $animateProvider.classNameFilter(/^(?:(?!wo-animate).)*$/);

        redactorOptions.plugins = ['filemanager', 'imagemanager', 'fullscreen'];
        redactorOptions.minHeight = 200;
        redactorOptions.buttons = [
          'html', 'formatting',
          'bold', 'italic', 'deleted',
          'unorderedlist', 'orderedlist',
          'outdent', 'indent',
          'image', 'file', 'link',
          'alignment',
          'horizontalrule'
        ];

        angular.extend(toastrConfig, {
          allowHtml: true,
          autoDismiss: true,
          containerId: 'toast-container',
          maxOpened: 1,
          newestOnTop: true,
          progressBar: false,
          tapToDismiss: false,
          timeOut: 30000,
          extendedTimeOut: 10000,
          positionClass: 'toast-bottom-right',
          preventOpenDuplicates: false,
          iconClasses: {
            error: 'error',
            info: 'info',
            success: 'success',
            warning: 'warning'
          },
          onTap: angular.noop
        });
      }
    ])

    .run([
      '$cookies',
      function ($cookies) {
        var $window = angular.element(window);

        if (typeof $cookies.get('timezone') === 'undefined') {
          $cookies.put('timezone', new Date().getTimezoneOffset() / 60);
        }

        $window.load(function () {
          angular.element('#global-loader').hide();
        });
      }
    ]);

})(angular, jQuery);