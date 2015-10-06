"use strict";

angular.module('BackendApp')

  .config(function (redactorOptions) {
    redactorOptions.fileUpload = '/feed/item/rest/upload/file';
    redactorOptions.imageUpload = '/feed/item/rest/upload/image';
  })

  .controller('ItemEditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'ToastScope', 'uiUploader', 'SectionDropdownScope',
    function ($scope, $http, $timeout, QueryScope, ToastScope, uiUploader, SectionDropdownScope) {
      $scope.inProgress = false;

      var selectedTab = QueryScope.get('tab', 'content');

      $scope.tabs = {
        content: selectedTab === 'content',
        picture: selectedTab === 'picture',
        sections: selectedTab === 'sections',
        publishing: selectedTab === 'publishing',
        meta: selectedTab === 'meta'
      };

      $scope.selectTab = function (tab) {
        QueryScope.set('tab', tab);

        $timeout(function () {
          jQuery(window).trigger('resize');
        });
      };

      $scope.sections = SectionDropdownScope;

      $timeout(function () {
        $scope.sections.reload(false);
      });

      $scope.submit = function (ItemEditForm, e) {
        var $form = angular.element('#ItemEditForm');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            item_id: $scope.$parent.getItem(),
            ItemEditForm: $scope.data
          }
        })
          .success(function (response) {
            if (response.result === false) {
              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                ToastScope.send('error', {
                  message: 'Save error'
                });
              }
            } else {
              ToastScope.send('success', {
                message: 'Item successfully saved'
              });

              QueryScope.set('id', response.item_id);

              $scope.reload();
            }
          })
          .error(function (response) {
            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              ToastScope.send('error', {
                message: 'Error updating item'
              });
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };

      $scope.previewInProgress = false;

      jQuery('body').on('change', '#picture', function (e) {
        var $uploadInput = jQuery(this);

        uiUploader.addFiles(e.target.files);

        $scope.previewInProgress = true;
        $scope.$apply();

        uiUploader.startUpload({
          url: $uploadInput.data('action'),
          concurrency: 1,
          onProgress: function (file) {
            //console.log('onProgress', arguments);
          },
          onCompleted: function (file, response, status) {
            //console.log('onCompleted', arguments);
            $uploadInput.val(null);

            if (status === 200) {
              response = jQuery.parseJSON(response);

              $scope.data.picture_media_id = response.id;
              $scope.data.picture_300 = response.url;
            } else {
              ToastScope.send('error', {message: 'Upload error'});
            }

            $scope.previewInProgress = false;

            $scope.$apply();
          },
          onCompletedAll: function () {
            //console.log('onCompletedAll', arguments);
          }
        });
      });
    }
  ]);