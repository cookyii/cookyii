"use strict";

angular.module('BackendApp')

  .controller('ClientListController', [
    '$scope', '$timeout', 'ClientListScope',
    function ($scope, $timeout, ClientListScope) {

      $scope.clients = ClientListScope($scope);

      function _refresh() {
        $scope.clients.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);