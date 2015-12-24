"use strict";

angular.module('scopes')

  .factory('QueryScope', [
    '$location',
    function ($location) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = $location.search();

        var converter = {
          'null': null,
          'true': true,
          'false': false
        };

        $scope.path = function (url) {
          $location.path(url);
        };

        $scope.get = function (key, defaultValue) {
          defaultValue = typeof defaultValue === 'undefined'
            ? null
            : defaultValue;

          var result = typeof query[key] === 'undefined' ? defaultValue : query[key];

          if (typeof converter[result] !== 'undefined') {
            result = converter[result];
          }

          return result;
        };

        $scope.set = function (key, value) {
          $location.search(key, value);
        };

        return $scope;
      };
    }
  ]);