"use strict";

angular.module('BackendApp')

  .controller('SectionDetailController', [
    '$scope', '$location', '$timeout', '$http', 'SectionResource',
    function ($scope, $location, $timeout, $http, Section) {
      var hash = null,
        query = $location.search(),
        defaultValues = {parent_id: null};

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

      if ($scope.isNewSection && typeof query.parent !== 'undefined') {
        defaultValues.parent_id = query.parent;
      }

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