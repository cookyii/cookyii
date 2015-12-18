"use strict";

angular.module('scopes')

  .factory('FilterSearchScope', [
    '$rootScope', 'QueryScope',
    function ($rootScope, QueryScope) {
      var $scope = $rootScope.$new();

      $scope.query = QueryScope.get('search');

      $scope.do = function () {
        QueryScope.set('search', $scope.query);

        _refresh();
      };

      $scope.clear = function () {
        $scope.query = null;
        $scope.do();
      };

      function _refresh() {
        $rootScope.$broadcast('refresh');
      }

      return $scope;
    }
  ]);