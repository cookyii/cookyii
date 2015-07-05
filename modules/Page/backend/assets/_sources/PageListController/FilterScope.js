"use strict";

angular.module('BackendApp')

  .service('FilterScope', [
    '$rootScope', 'QueryScope', 'FilterSearchScope',
    function ($rootScope, QueryScope, FilterSearchScope) {
      var $scope = $rootScope.$new();

      $scope.search = FilterSearchScope;

      $scope.deleted = QueryScope.get('deleted', false);

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
  ]);