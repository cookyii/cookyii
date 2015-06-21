"use strict";

angular.module('BackendApp')

  .controller('TemplateDetailController', [
    '$scope', '$location', '$timeout', 'TemplateResource',
    function ($scope, $location, $timeout, Template) {
      var hash = null,
        query = $location.search(),
        defaultValues = {roles: []};

      $scope.getTemplateId = function () {
        return typeof query.id === 'undefined'
          ? null
          : parseInt(query.id);
      };

      $scope.isNewTemplate = $scope.getTemplateId() === null;

      $scope.$on('reloadTemplateData', function (e) {
        $scope.reload();
      });

      $scope.reload = function (TemplateEditForm) {
        $scope.isNewTemplate = $scope.getTemplateId() === null;

        $scope.templateUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getTemplateId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Template.detail({id: $scope.getTemplateId()}, function (template) {
            $scope.data = template;
            hash = template.hash;

            $scope.$broadcast('templateDataReloaded', template);
          });
        }

        if (typeof TemplateEditForm === 'object') {
          TemplateEditForm.$setPristine();
        }
      };

      $timeout($scope.reload);
      $timeout(checkTemplateUpdate, 5000);

      $scope.templateUpdatedWarning = false;

      function checkTemplateUpdate() {
        if ($scope.getTemplateId() !== null) {
          Template.detail({id: $scope.getTemplateId()}, function (template) {
            if (hash !== template.hash) {
              $scope.templateUpdatedWarning = true;
            }
          });

          $timeout(checkTemplateUpdate, 5000);
        }
      }
    }
  ]);