(function (ng, $) {
  "use strict";

  ng.module('FrontendApp', [
    'ngSanitize',
    'ngMaterial',
    'ui.bootstrap',
    'angular-loading-bar'
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

        $mdThemingProvider.theme('default');
      }
    ]);

})(angular, jQuery);