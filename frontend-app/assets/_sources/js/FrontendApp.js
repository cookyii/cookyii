(function (ng, $) {
  "use strict";

  ng.module('FrontendApp', [
    'ngCookies', 'ngSanitize',
    'ui.bootstrap',
    'angular-loading-bar',
    'filters'
  ])

    .config([
      '$httpProvider', '$animateProvider', 'redactorOptions',
      function ($httpProvider, $animateProvider, redactorOptions) {
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