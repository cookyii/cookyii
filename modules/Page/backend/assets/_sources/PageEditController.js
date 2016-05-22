"use strict";

angular.module('BackendApp')

  .config(function (redactorOptions) {
    redactorOptions.fileUpload = '/page/rest/upload/file';
    redactorOptions.imageUpload = '/page/rest/upload/image';
  })

  .controller('PageEditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'TabScope', 'ToastrScope',
    function ($scope, $http, $timeout, QueryScope, TabScope, ToastrScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.tab = TabScope($scope);

      $scope.submit = function (PageEditForm, e) {
        var $form = angular.element('#PageEditForm');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            page_id: $scope.$parent.getPageId(),
            PageEditForm: $scope.data
          }
        })
          .then(function (response) {
            if (response.data.result === false) {
              if (typeof response.data.errors !== 'undefined') {
                angular.forEach(response.data.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toastr.error('Save error');
              }
            } else {
              toastr.success('Page successfully saved');

              if ($scope.$parent.isNewPage) {
                query.set('id', response.data.page_id);
              }

              $scope.reload();
            }
          }, function (response) {
            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating page');
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };
    }
  ]);