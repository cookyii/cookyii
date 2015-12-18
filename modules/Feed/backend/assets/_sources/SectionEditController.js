"use strict";

angular.module('BackendApp')

  .controller('SectionEditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'ToastrScope', 'SectionDropdownScope',
    function ($scope, $http, $timeout, QueryScope, ToastrScope, SectionDropdownScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      var selectedTab = query.get('tab', 'parent');

      $scope.tabs = {
        parent: selectedTab === 'parent',
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

      function reloadSectionList() {
        $scope.sections.reload(true, function () {
          if ($scope.$parent.getSection() !== null) {
            $scope.sections.checkCurrentSection($scope.$parent.getSection());
          }
        });
      }

      $timeout(reloadSectionList);

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
                toastr.error('Save error');
              }
            } else {
              toastr.success('Section successfully saved');

              query.set('section', response.section_slug);

              $timeout(function () {
                reloadSectionList();
                $scope.$parent.reload();
              });
            }
          })
          .error(function (response) {
            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating section');
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };
    }
  ]);