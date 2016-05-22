"use strict";

angular.module('BackendApp')

  .controller('account.edit.PropertiesController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'ToastrScope',
    function ($scope, $http, $timeout, QueryScope, ToastrScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.limit = 5;
      $scope.detailedList = false;

      $scope.isNewProperty = false;
      $scope.editedProperty = null;

      $scope.$on('accountDataReloaded', function (e, account) {
        if (query.get('prop') === '__new') {
          $scope.create();
        } else {
          angular.forEach(account.properties, function (item) {
            if (item.key === query.get('prop')) {
              $scope.edit(item);
            }
          });
        }
      });

      $scope.toggleAllProperties = function () {
        $scope.detailedList = !$scope.detailedList;
      };

      $scope.cancel = function () {
        $scope.isNewProperty = false;
        $scope.editedProperty = null;

        query.set('prop', null);
      };

      $scope.create = function () {
        $scope.isNewProperty = true;
        $scope.editedProperty = {};

        query.set('prop', '__new');
      };

      $scope.edit = function (property) {
        $scope.isNewProperty = false;
        $scope.editedProperty = property;

        $timeout(function () {
          // need for adjust angular elastic
          angular.element(window)
            .trigger('resize');
        }, 100);

        query.set('prop', $scope.editedProperty.key);
      };

      $scope.save = function (property, createNew) {
        createNew = typeof createNew === 'boolean'
          ? createNew
          : false;

        $http({
          method: 'POST',
          url: '/account/rest/property',
          data: {
            key: query.get('prop'),
            account_id: $scope.$parent.getAccountId(),
            property: $scope.editedProperty
          }
        })
          .then(function (response) {
            if (response.data.result === false) {
              if (typeof response.data.errors !== 'undefined') {
                angular.forEach(response.data.errors, function (error) {
                  toastr.error(error);
                });
              } else {
                toastr.error(response.data.message);
              }
            } else {
              if (!createNew) {
                query.set('prop', $scope.editedProperty.key);
              }

              $scope.$emit('reloadAccountData');

              toastr.success(response.data.message);
            }
          }, function (response, status) {
            toastr.error(response.data.message);
          });
      };

      $scope.remove = function (property, e) {
        swal({
          type: "warning",
          title: "Would you like to delete this property?",
          showCancelButton: true,
          closeOnConfirm: true,
          showLoaderOnConfirm: true,
          confirmButtonText: "Please do it!",
          cancelButtonText: "Cancel"
        }, function () {
          $http({
            method: 'DELETE',
            url: '/account/rest/property',
            params: {
              key: query.get('prop'),
              account_id: $scope.$parent.getAccountId()
            }
          })
            .then(function (response) {
              if (response.data.result === false) {
                toastr.error(response.data.message);
              } else {
                $scope.$emit('reloadAccountData');

                query.set('prop', null);

                toastr.success(response.data.message);

                $scope.editedProperty = null;
              }
            }, function (response, status) {
              toastr.error(response.data.message);
            });
        });
      };
    }
  ]);