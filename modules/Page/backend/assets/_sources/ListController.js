"use strict";

angular.module('BackendApp')

  .controller('page.ListController', [
    '$scope', '$timeout', 'page.list.ListScope',
    function ($scope, $timeout, ListScope) {

      $scope.pages = ListScope($scope);

      function _refresh() {
        $scope.pages.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);