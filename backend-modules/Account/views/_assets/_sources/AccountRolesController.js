"use strict";

angular.module('BackendApp')

  .controller('AccountRolesController', [
    '$scope', '$http', '$timeout', '$mdToast',
    function ($scope, $http, $timeout, $mdToast) {
      $scope.saveRoles = function () {
        $http({
          method: 'PUT',
          url: '/account/rest/roles',
          data: {
            user_id: $scope.$parent.getUserId(),
            roles: $scope.$parent.data.roles
          }
        })
          .success(function (response) {
            $scope.$emit('reloadUserData');
          })
          .error(function (response, status) {
            toast($mdToast, 'error', {
              message: response.message
            });
          });
      };
    }
  ]);