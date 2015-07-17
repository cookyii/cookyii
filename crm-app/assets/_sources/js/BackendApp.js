(function (ng, $) {
  "use strict";

  ng.module('BackendApp', [
    'ngCookies', 'ngSanitize', 'ngResource', 'ngAnimate', 'ngMaterial',
    'ui.bootstrap',
    'directives', 'truncate',
    'monospaced.elastic',
    'angular-loading-bar', 'angular-redactor'
  ])

    .config([
      '$httpProvider', '$animateProvider', '$mdThemingProvider',
      function ($httpProvider, $animateProvider, $mdThemingProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        $animateProvider.classNameFilter(/^(?:(?!wo-animate).)*$/);

        var $token = $('meta[name=token]');
        if ($token.length > 0) {
          //      $httpProvider.defaults.headers.common['Authorization'] = 'Bearer ' + $token.prop('content');
          //      @todo конфликт с http auth сервера
        }

        $mdThemingProvider.theme('default')
          .accentPalette('deep-purple');
      }
    ])

    .run([
      '$cookies',
      function ($cookies) {
        if (typeof $cookies.get('timezone') === 'undefined') {
          $cookies.put('timezone', new Date().getTimezoneOffset() / 60);
        }
      }
    ])

    .filter('nl2br', function () {
      return function (input) {
        if (input !== void 0) {
          return input.replace(/\n/g, '<br>');
        }
      };
    });

})(angular, jQuery);