"use strict";

angular.module('BackendApp')

  .controller('ClientDetailController', [
    '$scope', '$location', '$timeout', 'ClientResource',
    function ($scope, $location, $timeout, Client) {
      var hash = null,
        query = $location.search(),
        defaultValues = {roles: []};

      $scope.getClientId = function () {
        return typeof query.id === 'undefined'
          ? null
          : parseInt(query.id);
      };

      $scope.isNewClient = $scope.getClientId() === null;

      $scope.$on('reloadClientData', function (e) {
        $scope.reload();
      });

      $scope.reload = function () {
        $scope.isNewClient = $scope.getClientId() === null;

        $scope.clientUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getClientId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Client.detail({id: $scope.getClientId()}, function (client) {
            $scope.data = client;
            hash = client.hash;

            $scope.$broadcast('clientDataReloaded', client);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkClientUpdate, 5000);

      $scope.clientUpdatedWarning = false;

      function checkClientUpdate() {
        if ($scope.getClientId() !== null) {
          Client.detail({id: $scope.getClientId()}, function (client) {
            if (hash !== client.hash) {
              $scope.clientUpdatedWarning = true;
            }
          });

          $timeout(checkClientUpdate, 5000);
        }
      }
    }
  ]);