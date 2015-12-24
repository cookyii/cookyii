"use strict";

angular.module('scopes')

  .factory('SortScope', [
    'QueryScope',
    function (QueryScope) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope);

        $scope.order = query.get('sort', '-id');

        $scope.setOrder = function (sort) {
          if ($scope.order === sort) {
            $scope.order = '-' + sort;
          } else {
            $scope.order = sort;
          }

          query.set('sort', $scope.order);

          _refresh();
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);