(function (ng, $) {
  "use strict";

  ng.module('FrontendApp', [
      'directives', 'filters', 'scopes',
      'ngCookies', 'ngSanitize',
      'ui.bootstrap',
      'angular-loading-bar', 'toastr'
    ])

    .config([
      '$httpProvider', '$animateProvider', 'toastrConfig',
      function ($httpProvider, $animateProvider, toastrConfig) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        $animateProvider.classNameFilter(/^(?:(?!wo-animate).)*$/);

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
        if (typeof $cookies.get('timezone') === 'undefined') {
          $cookies.put('timezone', new Date().getTimezoneOffset() / 60);
        }
      }
    ]);

})(angular, jQuery);