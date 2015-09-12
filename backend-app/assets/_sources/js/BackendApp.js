(function (ng, $) {
  "use strict";

  ng.module('BackendApp', [
    'ngCookies', 'ngSanitize', 'ngResource', 'ngAnimate', 'ngMaterial',
    'ui.bootstrap',
    'directives', 'filters',
    'monospaced.elastic',
    'angular-loading-bar', 'angular-redactor'
  ])

    .config([
      '$httpProvider', '$animateProvider', '$mdThemingProvider',
      function ($httpProvider, $animateProvider, $mdThemingProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        $animateProvider.classNameFilter(/^(?:(?!wo-animate).)*$/);

        $mdThemingProvider.theme('default')
          .accentPalette('red');
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