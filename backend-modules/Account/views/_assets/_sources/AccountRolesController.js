"use strict";

angular.module('BackendApp')

  .controller('AccountRolesController', [
    '$scope', '$window', '$location', '$http', '$timeout', '$mdToast', '$mdDialog',
    function ($scope, $window, $location, $http, $timeout, $mdToast, $mdDialog) {
      var query = $location.search(),
        user_id;

      user_id = typeof query.id === 'undefined'
        ? null
        : parseInt(query.id);

      $scope.saveRoles = function () {
        $http({
          method: 'PUT',
          url: '/account/rest/roles',
          data: {user_id: user_id, roles: $scope.$parent.data.roles}
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