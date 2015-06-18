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
            account_id: $scope.$parent.getAccountId(),
            roles: $scope.$parent.data.roles
          }
        })
          .success(function (response) {
            $scope.$emit('reloadAccountData');
          })
          .error(function (response, status) {
            toast($mdToast, 'error', {
              message: response.message
            });
          });
      };
    }
  ]);