"use strict";

angular.module('BackendApp')

  .controller('TemplateDetailController', [
    '$scope', '$timeout', 'QueryScope', 'TemplateResource',
    function ($scope, $timeout, QueryScope, Template) {

      var hash = null,
        query = QueryScope($scope),
        defaultValues = {
          subject: null,
          content_text: null,
          content_html: null,
          use_layout: true,
          address: [],
          params: []
        };

      $scope.getTemplateId = function () {
        return query.get('id');
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