"use strict";

angular.module('BackendApp')

  .controller('postman.template.ListController', [
    '$scope', '$timeout', 'postman.template.list.ListScope',
    function ($scope, $timeout, ListScope) {

      $scope.templates = ListScope($scope);

      function _refresh() {
        $scope.templates.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);