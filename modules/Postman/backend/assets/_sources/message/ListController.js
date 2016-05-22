"use strict";

angular.module('BackendApp')

  .controller('postman.message.ListController', [
    '$scope', '$timeout', 'postman.message.list.ListScope',
    function ($scope, $timeout, ListScope) {

      $scope.messages = ListScope($scope);

      function _refresh() {
        $scope.messages.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);