"use strict";

angular.module('BackendApp')

  .controller('ItemDetailController', [
    '$scope', '$location', '$timeout', '$http', 'ItemResource',
    function ($scope, $location, $timeout, $http, Item) {
      var hash = null,
        query = $location.search(),
        defaultValues = {sections: []};

      $scope.data = {};

      $scope.getItem = function () {
        return typeof query.id === 'undefined'
          ? null
          : query.id;
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

      if ($scope.isNewItem && typeof query.section !== 'undefined') {
        defaultValues.sections = [query.section];
      }

      $scope.isItemDisabled = function (item) {
        return $scope.getItem() === item;
      };

      $scope.reload = function () {
        $scope.isNewItem = $scope.getItem() === null;

        $scope.itemUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getItem() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Item.detail({id: $scope.getItem()}, function (response) {
            $scope.data = response;
            hash = response.hash;

            $scope.$broadcast('itemDataReloaded', response);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkItemUpdate, 5000);

      $scope.itemUpdatedWarning = false;

      function checkItemUpdate() {
        if ($scope.getItem() !== null) {
          Item.detail({id: $scope.getItem()}, function (item) {
            if (hash !== item.hash) {
              $scope.itemUpdatedWarning = true;
            }
          });

          $timeout(checkItemUpdate, 5000);
        }
      }
    }
  ]);