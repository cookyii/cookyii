"use strict";

angular.module('BackendApp')

  .controller('AccountPropertiesController', [
    '$scope', '$window', '$location', '$http', '$timeout', 'ToastScope', 'UdpWebSocket', '$mdDialog',
    function ($scope, $window, $location, $http, $timeout, ToastScope, UdpWebSocket, $mdDialog) {
      var query = $location.search();

      $scope.limit = 5;
      $scope.detailedList = false;

      $scope.isNewProperty = false;
      $scope.editedProperty = null;

      $scope.$on('accountDataReloaded', function (e, account) {
        if (query.prop === '__new') {
          $scope.create();
        } else {
          angular.forEach(account.properties, function (item) {
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

      $scope.save = function (property, createNew) {
        createNew = typeof createNew === 'boolean'
          ? createNew
          : false;

        $http({
          method: 'POST',
          url: '/account/rest/property',
          data: {
            key: query.prop,
            account_id: $scope.$parent.getAccountId(),
            property: $scope.editedProperty
          }
        })
          .success(function (response) {
            if (response.result === false) {
              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (error) {
                  ToastScope.send('error', {
                    message: error
                  });
                });
              } else {
                ToastScope.send('error', {
                  message: response.message
                });
              }
            } else {
              if (!createNew) {
                $location.search('prop', $scope.editedProperty.key);
              }

              UdpWebSocket.send('reload-account-' + $scope.$parent.getAccountId());

              $scope.$emit('reloadAccountData');

              ToastScope.send('success', {
                message: response.message
              });
            }
          })
          .error(function (response, status) {
            ToastScope.send('error', {
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
            url: '/account/rest/property',
            params: {
              key: query.prop,
              account_id: $scope.$parent.getAccountId()
            }
          })
            .success(function (response) {
              if (response.result === false) {
                ToastScope.send('error', {
                  message: response.message
                });
              } else {
                UdpWebSocket.send('reload-account-' + $scope.$parent.getAccountId());

                $scope.$emit('reloadAccountData');

                $location.search('prop', null);

                ToastScope.send('success', {
                  message: response.message
                });

                $scope.editedProperty = null;
              }
            })
            .error(function (response, status) {
              ToastScope.send('error', {
                message: response.message
              });
            });
        });
      };
    }
  ]);