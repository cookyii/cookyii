"use strict";

angular.module('BackendApp')

  .factory('FilterScope', [
    '$rootScope', 'QueryScope', 'FilterSearchScope',
    function ($rootScope, QueryScope, FilterSearchScope) {
      var $scope = $rootScope.$new();

      $scope.search = FilterSearchScope;

      $scope.deleted = QueryScope.get('deleted', false) === 'true';

      $scope.toggleDeleted = function () {
        $scope.deleted = !$scope.deleted;

        QueryScope.set('deleted', $scope.deleted === true ? 'true' : 'false');

        _refresh();
      };

      function _refresh() {
        $rootScope.$broadcast('refresh');
      }

      return $scope;
    }
  ])

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