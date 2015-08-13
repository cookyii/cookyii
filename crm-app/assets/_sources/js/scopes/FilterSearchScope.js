"use strict";

angular.module('CrmApp')

  .factory('FilterSearchScope', [
    '$rootScope', '$mdUtil', 'QueryScope',
    function ($rootScope, $mdUtil, QueryScope) {
      var $scope = $rootScope.$new();

      $scope.query = QueryScope.get('search');

      $scope.do = $mdUtil.debounce(function () {
        QueryScope.set('search', $scope.query);

        _refresh();
      }, 500);

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