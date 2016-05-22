"use strict";

angular.module('CrmApp')

  .controller('client.ListController', [
    '$scope', '$timeout', 'client.list.ListScope',
    function ($scope, $timeout, ListScope) {

      $scope.clients = ListScope($scope);

      function _refresh() {
        $scope.clients.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);