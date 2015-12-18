"use strict";

angular.module('BackendApp')

  .config(function (redactorOptions) {
    redactorOptions.fileUpload = '/page/rest/upload/file';
    redactorOptions.imageUpload = '/page/rest/upload/image';
  })

  .controller('PageEditController', [
    '$scope', '$http', '$location', '$timeout', 'ToastrScope',
    function ($scope, $http, $location, $timeout, ToastrScope) {

      var query = $location.search(),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      var selectedTab = typeof query.tab === 'undefined'
        ? 'content'
        : query.tab;

      $scope.tabs = {
        content: selectedTab === 'content',
        meta: selectedTab === 'meta'
      };

      $scope.selectTab = function (tab) {
        $location.search('tab', tab);

        $timeout(function () {
          jQuery(window).trigger('resize');
        });
      };

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
          .success(function (response) {
            if (response.result === false) {
              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toastr.error('Save error');
              }
            } else {
              toastr.success('Page successfully saved');

              if ($scope.$parent.isNewPage) {
                $location.search('id', response.page_id);
              }

              $scope.reload();
            }
          })
          .error(function (response) {
            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
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