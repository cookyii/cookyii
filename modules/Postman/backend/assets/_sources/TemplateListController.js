"use strict";

angular.module('BackendApp')

  .controller('TemplateListController', [
    '$scope', '$timeout', 'TemplateListScope',
    function ($scope, $timeout, TemplateListScope) {

      $scope.templates = TemplateListScope($scope);

      function _refresh() {
        $scope.templates.reload(false);
      }

      $scope.$on('refresh', _refresh);

      $timeout(_refresh);
    }
  ]);