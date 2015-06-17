"use strict";

angular.module('BackendApp')

  .controller('AccountDetailController', [
    '$scope', '$location', '$timeout', 'UserResource',
    function ($scope, $location, $timeout, User) {
      var hash = null,
        query = $location.search(),
        defaultValues = {roles: []};

      $scope.getUserId = function () {
        return typeof query.id === 'undefined'
          ? null
          : parseInt(query.id);
      };

      $scope.isNewUser = $scope.getUserId() === null;

      $scope.$on('reloadUserData', function (e) {
        $scope.reload();
      });

      $scope.reload = function () {
        $scope.isNewUser = $scope.getUserId() === null;

        $scope.userUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getUserId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          User.detail({user: $scope.getUserId()}, function (user) {
            $scope.data = user;
            hash = user.hash;

            $scope.$broadcast('userDataReloaded', user);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkUserUpdate, 5000);

      $scope.userUpdatedWarning = false;

      function checkUserUpdate() {
        if ($scope.getUserId() !== null) {
          User.detail({user: $scope.getUserId()}, function (user) {
            if (hash !== user.hash) {
              $scope.userUpdatedWarning = true;
            }
          });

          $timeout(checkUserUpdate, 5000);
        }
      }
    }
  ]);