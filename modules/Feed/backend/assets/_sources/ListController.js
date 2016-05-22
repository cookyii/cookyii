"use strict";

angular.module('BackendApp')

  .controller('ListController', [
    '$scope', '$timeout', 'ItemListScope',
    function ($scope, $timeout, ItemListScope) {

      $scope.items = ItemListScope($scope);

      function _refresh() {
        $scope.items.filter.section.reload();
        $scope.items.reload();
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);