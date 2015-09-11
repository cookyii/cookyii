"use strict";

angular.module('BackendApp')

  .controller('AccountRolesController', [
    '$scope', '$http', 'ToastScope',
    function ($scope, $http, ToastScope) {
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
            //UdpWebSocket.send('reload-account-' + $scope.$parent.getAccountId());

            $scope.$emit('reloadAccountData');
          })
          .error(function (response, status) {
            ToastScope.send('error', {
              message: response.message
            });
          });
      };
    }
  ]);