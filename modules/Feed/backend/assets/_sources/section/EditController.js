"use strict";

angular.module('BackendApp')

  .controller('feed.section.EditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'TabScope', 'ToastrScope', 'feed.SectionDropdownScope',
    function ($scope, $http, $timeout, QueryScope, TabScope, ToastrScope, SectionDropdownScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.tab = TabScope($scope);

      $scope.sections = SectionDropdownScope($scope);

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
              toastr.success('Section successfully saved');

              query.set('section', response.data.section_slug);

              $timeout(function () {
                reloadSectionList();
                $scope.$parent.reload();
              });
            }
          }, function (response) {
            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
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