"use strict";

angular.module('BackendApp')

  .controller('ListController', [
    '$scope', '$timeout', 'AccountListScope',
    function ($scope, $timeout, AccountListScope) {

      $scope.accounts = AccountListScope($scope);

      function _refresh() {
        $scope.accounts.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);