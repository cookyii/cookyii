(function (ng, $) {
  "use strict";

  ng.module('CrmApp', [
    'ngCookies', 'ngSanitize', 'ngResource', 'ngAnimate', 'ngMaterial',
    'ui.bootstrap',
    'directives', 'filters',
    'monospaced.elastic',
    'angular-loading-bar', 'angular-redactor'
  ])

    .config([
      '$httpProvider', '$animateProvider', '$mdThemingProvider', 'redactorOptions',
      function ($httpProvider, $animateProvider, $mdThemingProvider, redactorOptions) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.common['X-CSRF-Token'] = yii.getCsrfToken();

        $animateProvider.classNameFilter(/^(?:(?!wo-animate).)*$/);

        $mdThemingProvider.theme('default')
          .accentPalette('deep-purple');

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