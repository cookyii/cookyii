"use strict";

angular.module('BackendApp')

  .controller('SectionDetailController', [
    '$scope', '$timeout', 'QueryScope', 'SectionResource',
    function ($scope, $timeout, QueryScope, Section) {
      var defaultValues = {parent_id: QueryScope.get('parent')};

      $scope.data = {};

      $scope.getSection = function () {
        return QueryScope.get('section');
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

      $scope.isSectionDisabled = function (section) {
        return $scope.getSection() === section;
      };

      $scope.reload = function () {
        $scope.isNewSection = $scope.getSection() === null;

        $scope.updatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getSection() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Section.detail({slug: $scope.getSection()}, function (section) {
            $scope.data = section;
            $scope.data.meta = $scope.data.meta.length === 0
              ? {}
              : $scope.data.meta;

            $scope.$broadcast('sectionDataReloaded', section);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkSectionUpdate, 5000);

      $scope.updatedWarning = false;

      function checkSectionUpdate() {
        if ($scope.getSection() !== null) {
          Section.detail({slug: $scope.getSection()}, function (section) {
            if ($scope.data.hash !== section.hash) {
              $scope.updatedWarning = true;
            }
          });

          $timeout(checkSectionUpdate, 5000);
        }
      }
    }
  ]);