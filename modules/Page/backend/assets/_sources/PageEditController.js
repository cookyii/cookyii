"use strict";

angular.module('BackendApp')

  .config(function (redactorOptions) {
    redactorOptions.plugins = ['filemanager', 'imagemanager', 'fullscreen'];
    redactorOptions.minHeight = 200;
    redactorOptions.fileUpload = '/page/rest/upload/file';
    redactorOptions.imageUpload = '/page/rest/upload/image';
    redactorOptions.buttons = [
      'html', 'formatting',
      'bold', 'italic', 'deleted',
      'unorderedlist', 'orderedlist',
      'outdent', 'indent',
      'image', 'file', 'link',
      'alignment',
      'horizontalrule'
    ];
  })

  .controller('PageEditController', [
    '$scope', '$http', '$location', '$timeout', '$mdToast',
    function ($scope, $http, $location, $timeout, $mdToast) {
      var query = $location.search();

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
                toast($mdToast, 'error', {
                  message: 'Save error'
                });
              }
            } else {
              toast($mdToast, 'success', {
                message: 'Page successfully saved'
              });

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
              toast($mdToast, 'error', {
                message: 'Error updating page'
              });
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };
    }
  ]);