"use strict";

angular.module('BackendApp')

  .controller('AccountEditController', [
    '$scope', '$location', '$http', '$timeout', '$mdToast', '$mdDialog', 'UserResource',
    function ($scope, $location, $http, $timeout, $mdToast, $mdDialog, User) {
      var hash = null,
        query = $location.search(),
        UserInstance,
        defaultValues = {
          roles: [],
          activated: true,
          deleted: false
        },
        user_id;

      user_id = typeof query.id === 'undefined'
        ? null
        : parseInt(query.id);

      $scope.in_progress = false;

      $scope.$on('reloadUserData', function (e, callback) {
        $scope.reload(callback);
      });

      $scope.reload = function (callback) {
        $scope.userUpdatedWarning = false;
        $scope.editedProperty = null;

        if (user_id === null) {
          $scope.data = angular.copy(defaultValues);
        }

        User.detail({user: user_id}, function (user) {
          $scope.data = user;

          if (typeof callback === 'function') {
            callback(user);
          }

          hash = user.hash;
        });
      };

      $scope.submit = function (e) {
        var handler;

        $scope.error = {};
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

      $scope.userUpdatedWarning = false;

      $scope.reload();
      $timeout(checkUserUpdate, 5000);

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
      }
    }
  ]);