"use strict";

angular.module('BackendApp')

  .controller('ListController', [
    '$scope', '$timeout', 'FilterScope', 'SectionScope', 'ItemScope',
    function ($scope, $timeout, FilterScope, SectionScope, ItemScope) {

      $scope.filter = FilterScope;
      $scope.section = SectionScope;
      $scope.items = ItemScope;

      $scope.fab = {
        isOpen: false,
        selectedMode: 'md-fling',
        selectedDirection: 'left'
      };

      $scope.$on('refresh', _refresh);

      function _refresh() {
        $scope.section.reload();
        $scope.items.reload();
      }

      $timeout($scope.section.reload);
      $timeout($scope.items.reload);
    }
  ]);