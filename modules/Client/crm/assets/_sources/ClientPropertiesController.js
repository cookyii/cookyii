"use strict";

angular.module('CrmApp')

  .controller('ClientPropertiesController', [
    '$scope', '$window', '$http', '$timeout', 'QueryScope', 'ToastrScope',
    function ($scope, $window, $http, $timeout, QueryScope, ToastrScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.limit = 5;
      $scope.detailedList = false;

      $scope.isNewProperty = false;
      $scope.editedProperty = null;

      $scope.$on('clientDataReloaded', function (e, client) {
        if (query.get('prop') === '__new') {
          $scope.create();
        } else {
          angular.forEach(client.properties, function (item) {
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
          angular.element($window)
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
          url: '/client/rest/property',
          data: {
            key: query.get('prop'),
            client_id: $scope.$parent.getClientId(),
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

              $scope.$emit('reloadClientData');

              toastr.success(response.data.message);
            }
          }, function (response) {
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
            url: '/client/rest/property',
            params: {
              key: query.get('prop'),
              client_id: $scope.$parent.getClientId()
            }
          })
            .then(function (response) {
              if (response.data.result === false) {
                toastr.error(response.data.message);
              } else {
                $scope.$emit('reloadClientData');

                query.set('prop', null);

                toastr.success(response.data.message);

                $scope.editedProperty = null;
              }
            }, function (response) {
              toastr.error(response.data.message);
            });
        });
      };
    }
  ]);