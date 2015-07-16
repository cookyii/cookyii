"use strict";

angular.module('BackendApp')

  .controller('MessageListController', [
    '$scope', '$timeout', 'MessageListScope',
    function ($scope, $timeout, MessageListScope) {

      $scope.messages = MessageListScope($scope);

      function _refresh() {
        $scope.messages.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);