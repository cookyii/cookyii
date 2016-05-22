"use strict";

angular.module('BackendApp')

  .controller('account.ListController', [
    '$scope', '$timeout', 'account.list.ListScope',
    function ($scope, $timeout, ListScope) {

      $scope.accounts = ListScope($scope);

      function _refresh() {
        $scope.accounts.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);