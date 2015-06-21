(function (ng, $) {
  "use strict";

  ng.module('BackendApp', [
    'ngSanitize', 'ngResource', 'ngMaterial',
    'ui.bootstrap',
    'angular-loading-bar', 'truncate', 'monospaced.elastic', 'angular-redactor'
  ])

    .config([
      '$httpProvider', '$mdThemingProvider',
      function ($httpProvider, $mdThemingProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        var $token = $('meta[name=token]');
        if ($token.length > 0) {
          //      $httpProvider.defaults.headers.common['Authorization'] = 'Bearer ' + $token.prop('content');
          //      @todo конфликт с http auth сервера
        }

        var deepPurpleTheme = $mdThemingProvider.extendPalette('deep-purple', {
          '400': '555299'
        });

        $mdThemingProvider.definePalette('deep-purple-theme', deepPurpleTheme);

        $mdThemingProvider.theme('default')
          .accentPalette('deep-purple-theme', {
            'default': '400'
          });
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