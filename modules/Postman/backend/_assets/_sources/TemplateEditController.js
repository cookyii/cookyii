"use strict";

angular.module('BackendApp')

  .controller('TemplateEditController', [
    '$scope', '$http', '$location', '$timeout', '$mdToast',
    function ($scope, $http, $location, $timeout, $mdToast) {
      var query = $location.search();

      $scope.inProgress = false;

      var selectedTab = typeof query.tab === 'undefined'
        ? 'content'
        : query.tab;

      $scope.tabs = {
        content: selectedTab === 'content',
        styles: selectedTab === 'styles',
        address: selectedTab === 'address',
        params: selectedTab === 'params',
        preview: selectedTab === 'preview'
      };

      $scope.selectTab = function (tab) {
        $location.search('tab', tab);

        $timeout(function () {
          jQuery(window).trigger('resize');
        });
      };

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
          .success(function (response) {
            if (response.result === false) {
              TemplateEditForm.$setDirty();

              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toast($mdToast, 'error', {
                  message: 'Save error'
                });
              }
            } else {
              toast($mdToast, 'success', {
                message: 'Template successfully saved'
              });

              if ($scope.$parent.isNewTemplate) {
                $location.search('id', response.template_id);
              }

              $scope.reload();
            }
          })
          .error(function (response) {
            TemplateEditForm.$setDirty();

            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toast($mdToast, 'error', {
                message: 'Error updating template'
              });
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      }
    }
  ]);