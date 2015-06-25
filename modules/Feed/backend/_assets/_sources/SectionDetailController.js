"use strict";

angular.module('BackendApp')

  .controller('SectionDetailController', [
    '$scope', '$location', '$timeout', '$http', 'SectionResource',
    function ($scope, $location, $timeout, $http, Section) {
      var hash = null,
        query = $location.search(),
        defaultValues = {parent_id: null},
        baseSectionId = false,
        baseSort = 0;

      $scope.data = {};

      $scope.getSection = function () {
        return typeof query.section === 'undefined'
          ? null
          : query.section;
      };

      $scope.isNewSection = $scope.getSection() === null;

      $scope.$on('reloadSectionData', function (e) {
        $scope.reload();
      });

      $scope.$watch('data.title', function (val) {
        if (typeof val !== 'undefined' && $scope.isNewSection) {
          $scope.data.slug = getSlug(val);
        }
      });

      $scope.$watch('data.parent_id', function (val) {
        if (typeof val === 'undefined') {
          return;
        }

        function reloadSort() {
          $http({
            method: 'GET',
            url: '/feed/section/rest/sort',
            params: {
              parent_section_id: val
            }
          })
            .success(function (response) {
              $scope.data.sort = parseInt(response) + 100;
            });
        }

        if (!$scope.isNewSection && baseSectionId === val) {
          $scope.data.sort = baseSort;
        } else {
          reloadSort();
        }
      });

      $scope.isSectionDisabled = function (section) {
        return $scope.getSection() === section;
      };

      $scope.reload = function () {
        $scope.isNewSection = $scope.getSection() === null;

        $scope.sectionUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getSection() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Section.detail({slug: $scope.getSection()}, function (section) {
            $scope.data = section;
            hash = section.hash;

            baseSectionId = section.parent_id;
            baseSort = section.sort;

            $scope.$broadcast('sectionDataReloaded', section);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkSectionUpdate, 5000);

      $scope.sectionUpdatedWarning = false;

      function checkSectionUpdate() {
        if ($scope.getSection() !== null) {
          Section.detail({slug: $scope.getSection()}, function (section) {
            if (hash !== section.hash) {
              $scope.sectionUpdatedWarning = true;
            }
          });

          $timeout(checkSectionUpdate, 5000);
        }
      }
    }
  ]);