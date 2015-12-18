"use strict";

angular.module('BackendApp')

  .config(function (redactorOptions) {
    redactorOptions.fileUpload = '/feed/item/rest/upload/file';
    redactorOptions.imageUpload = '/feed/item/rest/upload/image';
  })

  .controller('ItemEditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'ToastrScope', 'uiUploader', 'SectionDropdownScope',
    function ($scope, $http, $timeout, QueryScope, ToastrScope, uiUploader, SectionDropdownScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      var selectedTab = query.get('tab', 'content');

      $scope.tabs = {
        content: selectedTab === 'content',
        picture: selectedTab === 'picture',
        sections: selectedTab === 'sections',
        publishing: selectedTab === 'publishing',
        meta: selectedTab === 'meta'
      };

      $scope.selectTab = function (tab) {
        query.set('tab', tab);

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
                toastr.error('Save error');
              }
            } else {
              toastr.success('Item successfully saved');

              query.set('id', response.item_id);

              $scope.reload();
            }
          })
          .error(function (response) {
            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating item');
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
              toastr.error('Upload error');
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