"use strict";

angular.module('BackendApp')

  .controller('PageDetailController', [
    '$scope', '$timeout', 'QueryScope', 'PageResource',
    function ($scope, $timeout, QueryScope, Page) {
      var hash = null,
        defaultValues = {roles: []};

      $scope.getPageId = function () {
        return QueryScope.get('id');
      };

      $scope.isNewPage = $scope.getPageId() === null;

      $scope.$on('reloadPageData', function (e) {
        $scope.reload();
      });

      $scope.$watch('data.title', function (val) {
        if (typeof val !== 'undefined' && $scope.isNewPage) {
          $scope.data.slug = getSlug(val);
        }
      });

      $scope.reload = function () {
        $scope.isNewPage = $scope.getPageId() === null;

        $scope.updatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getPageId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Page.detail({id: $scope.getPageId()}, function (page) {
            $scope.data = page;
            $scope.data.meta = $scope.data.meta.length === 0
              ? {}
              : $scope.data.meta;

            hash = page.hash;

            $scope.$broadcast('pageDataReloaded', page);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkPageUpdate, 5000);

      $scope.updatedWarning = false;

      function checkPageUpdate() {
        if ($scope.getPageId() !== null) {
          Page.detail({id: $scope.getPageId()}, function (page) {
            if (hash !== page.hash) {
              $scope.updatedWarning = true;
            }
          });

          $timeout(checkPageUpdate, 5000);
        }
      }
    }
  ]);