"use strict";

angular.module('BackendApp')

  .config(function (redactorOptions) {
    redactorOptions.fileUpload = '/feed/item/rest/upload/file';
    redactorOptions.imageUpload = '/feed/item/rest/upload/image';
  })

  .controller('feed.item.EditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'TabScope', 'ToastrScope', 'uiUploader', 'feed.SectionDropdownScope',
    function ($scope, $http, $timeout, QueryScope, TabScope, ToastrScope, uiUploader, SectionDropdownScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.tab = TabScope($scope);

      $scope.sections = SectionDropdownScope($scope);

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
              toastr.success('Item successfully saved');

              query.set('id', response.data.item_id);

              $scope.reload();
            }
          }, function (response) {
            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
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