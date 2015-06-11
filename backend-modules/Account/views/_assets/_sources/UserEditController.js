"use strict";

angular.module('BackendApp')

  .controller('UserEditController', [
    '$rootScope', '$scope', '$element', '$http', '$mdToast', 'UserResource',
    function ($rootScope, $scope, $modal, $http, $mdToast, User) {
      var UserInstance,
        defaultValues = {
          roles: [],
          activated: true,
          deleted: false
        },
        defaultErrors = {};

      $scope.in_progress = false;

      resetData();
      resetErrors();

      $scope.submit = function (e) {
        var handler;

        resetErrors();

        $scope.in_progress = true;

        if (UserInstance === null) {
          handler = function (a, b) {
            new User($scope.data).$save(a, b);
          };
        } else {
          handler = function (a, b) {
            UserInstance.$update(a, b);
          };
        }

        handler(function () {
          toast($mdToast, 'success', {
            message: 'Account successfully updated'
          });

          $modal.modal('hide');
          $rootScope.$broadcast('ListRefresh');

          $scope.in_progress = false;
        }, function (response) {
          if (typeof response.data !== 'undefined') {
            angular.forEach(response.data, function (val, index) {
              $scope.error[val.field] = val.message;
            });
          } else {
            toast($mdToast, 'error', {
              message: 'Error updating account'
            });
          }

          $scope.in_progress = false;
        });

        e.preventDefault();
      };

      $modal.find('#AccountEditForm').bind('reset', function () {
        $modal.modal('hide');
      });

      $rootScope.$on('editAccount', function (event, user) {
        UserInstance = user;

        resetData();
        resetErrors();

        if (user === null) {
          $scope.data.roles.user = true;
        } else {
          $scope.data = user;

          $scope.data.activated = $scope.data.activated === 1;
          $scope.data.deleted = $scope.data.deleted === 1;

          var roles = angular.copy($scope.data.roles);
          $scope.data.roles = {};

          angular.forEach(roles, function (label, key) {
            $scope.data.roles[key] = true;
          });

          $scope.data.roles.user = true;
        }
      });

      function resetData() {
        $scope.data = angular.copy(defaultValues);
      }

      function resetErrors() {
        $scope.error = angular.copy(defaultErrors);
      }
    }
  ]);