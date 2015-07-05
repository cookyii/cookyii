"use strict";

angular.module('BackendApp')

  .controller('PageListController', [
    '$scope', '$timeout', 'FilterScope', 'PageListScope',
    function ($scope, $timeout, FilterScope, PageListScope) {

      $scope.filter = FilterScope;
      $scope.pages = PageListScope;

      function _refresh() {
        $scope.pages.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);