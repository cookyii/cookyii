"use strict";

angular.module('BackendApp')

  .controller('postman.template.EditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'TabScope', 'ToastrScope',
    function ($scope, $http, $timeout, QueryScope, TabScope, ToastrScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.tab = TabScope($scope);

      $scope.addAddress = function () {
        $scope.$parent.data.address.push({
          type: 'null',
          email: null,
          name: null
        });
      };

      $scope.removeAddress = function (index) {
        delete $scope.$parent.data.address[index];
      };

      $scope.addParameter = function () {
        $scope.$parent.data.params.push({
          key: null,
          description: null
        });
      };

      $scope.removeParameter = function (index) {
        delete $scope.$parent.data.params[index];
      };

      $scope.previewUrl = function (template, type) {
        if (typeof template === 'undefined') {
          return false;
        }

        return '/postman/template/preview?'
          + 'type=' + encodeURIComponent(type)
          + '&subject=' + encodeURIComponent(template.subject)
          + '&content=' + encodeURIComponent(type === 'html' ? template.content_html : template.content_text)
          + '&styles=' + encodeURIComponent(template.styles)
          + '&use_layout=' + encodeURIComponent(template.use_layout);
      };

      $scope.submit = function (TemplateEditForm, e) {
        var $form = angular.element('#TemplateEditForm');

        TemplateEditForm.$setPristine();

        $scope.error = {};
        $scope.inProgress = true;
        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            template_id: $scope.$parent.getTemplateId(),
            TemplateEditForm: $scope.data
          }
        })
          .then(function (response) {
            if (response.data.result === false) {
              TemplateEditForm.$setDirty();

              if (typeof response.data.errors !== 'undefined') {
                angular.forEach(response.data.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toastr.error('Save error');
              }
            } else {
              toastr.success('Template successfully saved');

              if ($scope.$parent.isNewTemplate) {
                query.set('id', response.data.template_id);
              }

              $scope.reload();
            }
          }, function (response) {
            TemplateEditForm.$setDirty();

            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating template');
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      }
    }
  ]);