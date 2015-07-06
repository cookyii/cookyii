"use strict";

angular.module('BackendApp')

  .controller('ListController', [
    '$scope', '$timeout', 'PageListScope',
    function ($scope, $timeout, PageListScope) {

      $scope.pages = PageListScope($scope);

      function _refresh() {
        $scope.pages.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);