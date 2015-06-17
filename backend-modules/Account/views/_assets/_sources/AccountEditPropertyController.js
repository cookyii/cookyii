"use strict";

angular.module('BackendApp')

  .controller('AccountEditPropertyController', [
    '$scope', '$window', '$location', '$http', '$timeout', '$mdToast', '$mdDialog',
    function ($scope, $window, $location, $http, $timeout, $mdToast, $mdDialog) {
      var query = $location.search(),
        user_id;

      user_id = typeof query.id === 'undefined'
        ? null
        : parseInt(query.id);

      $scope.limit = 5;
      $scope.detailedList = false;

      $scope.isNewProperty = false;
      $scope.editedProperty = null;

      $scope.$on('userDataReloaded', function (e, user) {
        if (query.prop === '__new') {
          $scope.create();
        } else {
          angular.forEach(user.properties, function (item) {
            if (item.key === query.prop) {
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

        $location.search('prop', null);
      };

      $scope.create = function () {
        $scope.isNewProperty = true;
        $scope.editedProperty = {};

        $location.search('prop', '__new');
      };

      $scope.edit = function (property) {
        $scope.isNewProperty = false;
        $scope.editedProperty = property;

        $timeout(function () {
          // need for adjust angular elastic
          angular.element($window)
            .trigger('resize');
        }, 100);

        $location.search('prop', $scope.editedProperty.key);
      };

      $scope.save = function (property) {
        $http({
          method: 'POST',
          url: '/account/rest/user-property',
          data: {
            key: query.prop,
            user_id: user_id,
            property: $scope.editedProperty
          }
        })
          .success(function (response) {
            if (response.result === false) {
              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (error) {
                  toast($mdToast, 'error', {
                    message: error
                  });
                });
              } else {
                toast($mdToast, 'error', {
                  message: response.message
                });
              }
            } else {
              $location.search('prop', $scope.editedProperty.key);

              $scope.$emit('reloadUserData');

              toast($mdToast, 'success', {
                message: response.message
              });
            }
          })
          .error(function (response, status) {
            toast($mdToast, 'error', {
              message: response.message
            });
          });
      };

      $scope.remove = function (property, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this property?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          $http({
            method: 'DELETE',
            url: '/account/rest/user-property',
            params: {
              key: query.prop,
              user_id: user_id
            }
          })
            .success(function (response) {
              if (response.result === false) {
                toast($mdToast, 'error', {
                  message: response.message
                });
              } else {
                $scope.$emit('reloadUserData');

                $location.search('prop', null);

                toast($mdToast, 'success', {
                  message: response.message
                });

                $scope.editedProperty = null;
              }
            })
            .error(function (response, status) {
              toast($mdToast, 'error', {
                message: response.message
              });
            });
        });
      };
    }
  ]);