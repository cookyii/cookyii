"use strict";

angular.module('BackendApp')

  .controller('AccountDetailController', [
    '$scope', '$location', '$http', '$timeout', '$mdToast', 'UserResource',
    function ($scope, $location, $http, $timeout, $mdToast, User) {
      var hash = null,
        query = $location.search(),
        UserInstance,
        defaultValues = {
          roles: [],
          activated: true,
          deleted: false
        },
        defaultErrors = {},
        user_id;

      user_id = typeof query.id === 'undefined'
        ? null
        : parseInt(query.id);

      $scope.in_progress = false;

      resetData();
      resetErrors();

      $scope.rbacOpened = {};

      $scope.toggleRbacGroup = function (key) {
        if (typeof $scope.rbacOpened[key] === 'undefined') {
          $scope.rbacOpened[key] = false;
        }

        $scope.rbacOpened[key] = !$scope.rbacOpened[key];
      };

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

      $scope.reloadPage = function () {
        location.reload();
      };

      $scope.userUpdatedWarning = false;

      reloadUserData();

      function reloadUserData() {
        if (user_id === null) {
          return;
        }

        User.detail({user: user_id}, function (user) {
          $scope.data = user;

          hash = user.hash;
        });

        $timeout(checkUserUpdate, 5000);
      }

      function checkUserUpdate() {
        User.detail({user: user_id}, function (user) {
          if (hash !== user.hash) {
            userUpdatedWarning();
          }
        });

        $timeout(checkUserUpdate, 5000);
      }

      function userUpdatedWarning() {
        $scope.userUpdatedWarning = true;
        console.warn('user updated, reload page');
      }

      function resetData() {
        $scope.data = angular.copy(defaultValues);
      }

      function resetErrors() {
        $scope.error = angular.copy(defaultErrors);
      }
    }
  ]);