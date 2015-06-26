"use strict";

angular.module('BackendApp')

  .controller('ItemEditController', [
    '$scope', '$http', '$location', '$timeout', '$mdToast',
    function ($scope, $http, $location, $timeout, $mdToast) {
      var query = $location.search();

      $scope.inProgress = false;

      var selectedTab = typeof query.tab === 'undefined'
        ? 'content'
        : query.tab;

      $scope.tabs = {
        content: selectedTab === 'content',
        sections: selectedTab === 'sections',
        publishing: selectedTab === 'publishing',
        meta: selectedTab === 'meta'
      };

      $scope.selectTab = function (tab) {
        $location.search('tab', tab);

        $timeout(function () {
          jQuery(window).trigger('resize');
        });
      };

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
                toast($mdToast, 'error', {
                  message: 'Save error'
                });
              }
            } else {
              toast($mdToast, 'success', {
                message: 'Item successfully saved'
              });

              $location.search('id', response.item_id);

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
                message: 'Error updating item'
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