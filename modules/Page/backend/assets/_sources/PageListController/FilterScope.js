"use strict";

angular.module('BackendApp')

  .service('FilterScope', [
    'QueryScope', 'FilterSearchScope',
    function (QueryScope, FilterSearchScope) {
      return function ($parentScope) {
        var $scope = $parentScope.$new();

        $scope.search = FilterSearchScope;

        $scope.deleted = QueryScope.get('deleted', false);

        $scope.toggleDeleted = function () {
          $scope.deleted = !$scope.deleted;

          QueryScope.set('deleted', $scope.deleted === true ? 'true' : 'false');

          _refresh();
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);