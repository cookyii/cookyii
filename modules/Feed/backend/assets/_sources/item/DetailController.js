"use strict";

angular.module('BackendApp')

  .controller('feed.item.DetailController', [
    '$scope', '$timeout', 'QueryScope', 'feed.ItemResource',
    function ($scope, $timeout, QueryScope, Item) {

      var query = QueryScope($scope),
        defaultValues = {sections: []};

      $scope.data = {};

      $scope.getItem = function () {
        return query.get('id');
      };

      $scope.isNewItem = $scope.getItem() === null;

      $scope.$on('reloadItemData', function (e) {
        $scope.reload();
      });

      $scope.$watch('data.title', function (val) {
        if (typeof val !== 'undefined' && $scope.isNewItem) {
          $scope.data.slug = getSlug(val);
        }
      });

      if ($scope.isNewItem && query.get('section') !== null) {
        defaultValues.sections = [parseInt(query.get('section'))];
      }

      $scope.isItemDisabled = function (item) {
        return $scope.getItem() === item;
      };

      $scope.reload = function () {
        $scope.isNewItem = $scope.getItem() === null;

        $scope.updatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getItem() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Item.detail({id: $scope.getItem()}, function (response) {
            $scope.data = response;
            $scope.data.meta = $scope.data.meta === null || $scope.data.meta.length === 0
              ? {}
              : $scope.data.meta;

            $scope.$broadcast('itemDataReloaded', response);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkItemUpdate, 5000);

      $scope.updatedWarning = false;

      function checkItemUpdate() {
        if ($scope.getItem() !== null) {
          Item.detail({id: $scope.getItem()}, function (item) {
            if ($scope.data.hash !== item.hash) {
              $scope.updatedWarning = true;
            }
          });

          $timeout(checkItemUpdate, 5000);
        }
      }
    }
  ]);