"use strict";

angular.module('CrmApp')

  .factory('SortScope', [
    'QueryScope',
    function (QueryScope) {
      return function ($parentScope) {
        var $scope = $parentScope.$new();

        $scope.order = QueryScope.get('sort', '-id');

        $scope.setOrder = function (sort) {
          if ($scope.order === sort) {
            $scope.order = '-' + sort;
          } else {
            $scope.order = sort;
          }

          QueryScope.set('sort', $scope.order);

          _refresh();
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);