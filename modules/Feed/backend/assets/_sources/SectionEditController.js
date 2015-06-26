"use strict";

angular.module('BackendApp')

  .controller('SectionEditController', [
    '$scope', '$http', '$location', '$timeout', '$mdToast',
    function ($scope, $http, $location, $timeout, $mdToast) {
      var query = $location.search();

      $scope.inProgress = false;

      var selectedTab = typeof query.tab === 'undefined'
        ? 'parent'
        : query.tab;

      $scope.tabs = {
        parent: selectedTab === 'parent',
        publishing: selectedTab === 'publishing',
        meta: selectedTab === 'meta'
      };

      $scope.selectTab = function (tab) {
        $location.search('tab', tab);

        $timeout(function () {
          jQuery(window).trigger('resize');
        });
      };

      $scope.submit = function (SectionEditForm, e) {
        var $form = angular.element('#SectionEditForm');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            section_slug: $scope.$parent.getSection(),
            SectionEditForm: $scope.data
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
                message: 'Section successfully saved'
              });

              $location.search('section', response.section_slug);

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
                message: 'Error updating section'
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