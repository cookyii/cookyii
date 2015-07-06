"use strict";

angular.module('BackendApp')

  .factory('FilterScope', [
    'QueryScope', 'FilterSearchScope', 'FilterSectionScope',
    function (QueryScope, FilterSearchScope, FilterSectionScope) {
      return function ($parentScope) {
        var $scope = $parentScope.$new();

        $scope.section = FilterSectionScope($scope);

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