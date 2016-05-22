"use strict";

angular.module('BackendApp')

  .controller('feed.ListController', [
    '$scope', '$timeout', 'feed.list.ItemListScope',
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