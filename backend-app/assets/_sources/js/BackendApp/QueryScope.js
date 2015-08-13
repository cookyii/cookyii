"use strict";

angular.module('BackendApp')

  .factory('QueryScope', [
    '$rootScope', '$location',
    function ($rootScope, $location) {
      var
        $scope = $rootScope.$new(),
        query = $location.search();

      var converter = {
        'null': null,
        'true': true,
        'false': false
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
    }
  ]);