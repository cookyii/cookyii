"use strict";

angular.module('BackendApp')

  .controller('PageDetailController', [
    '$scope', '$location', '$timeout', 'PageResource',
    function ($scope, $location, $timeout, Page) {
      var hash = null,
        query = $location.search(),
        defaultValues = {roles: []};

      $scope.getPageId = function () {
        return typeof query.id === 'undefined'
          ? null
          : parseInt(query.id);
      };

      $scope.isNewPage = $scope.getPageId() === null;

      $scope.$on('reloadPageData', function (e) {
        $scope.reload();
      });

      $scope.$watch('data.title', function (val) {
        if (typeof val !== 'undefined' && $scope.isNewItem) {
          $scope.data.slug = getSlug(val);
        }
      });

      $scope.reload = function () {
        $scope.isNewPage = $scope.getPageId() === null;

        $scope.pageUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getPageId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Page.detail({id: $scope.getPageId()}, function (page) {
            $scope.data = page;
            hash = page.hash;

            $scope.$broadcast('pageDataReloaded', page);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkPageUpdate, 5000);

      $scope.pageUpdatedWarning = false;

      function checkPageUpdate() {
        if ($scope.getPageId() !== null) {
          Page.detail({id: $scope.getPageId()}, function (page) {
            if (hash !== page.hash) {
              $scope.pageUpdatedWarning = true;
            }
          });

          $timeout(checkPageUpdate, 5000);
        }
      }
    }
  ]);