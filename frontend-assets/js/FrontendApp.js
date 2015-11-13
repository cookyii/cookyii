(function (ng, $) {
  "use strict";

  ng.module('FrontendApp', [
    'ngCookies', 'ngSanitize', 'ngMaterial',
    'ui.bootstrap', 'ui.uploader',
    'angular-loading-bar',
    'filters'
  ])

    .config([
      '$httpProvider', '$animateProvider',
      function ($httpProvider, $animateProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        $animateProvider.classNameFilter(/^(?:(?!wo-animate).)*$/);
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