"use strict";

angular.module('BackendApp')

  .controller('ListController', [
    '$scope', '$timeout', 'FilterScope', 'SectionListScope', 'ItemListScope',
    function ($scope, $timeout, FilterScope, SectionListScope, ItemListScope) {

      $scope.filter = FilterScope;
      $scope.section = SectionListScope;
      $scope.items = ItemListScope;

      $scope.fab = {
        isOpen: false,
        selectedMode: 'md-fling',
        selectedDirection: 'left'
      };

      function _refresh() {
        $scope.section.reload();
        $scope.items.reload();
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);