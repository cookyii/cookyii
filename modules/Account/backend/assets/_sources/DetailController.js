"use strict";

angular.module('BackendApp')

  .controller('account.DetailController', [
    '$scope', '$timeout', 'QueryScope', 'account.AccountResource',
    function ($scope, $timeout, QueryScope, Account) {

      var hash = null,
        query = QueryScope($scope),
        defaultValues = {gender: '1', roles: {user: true}};

      $scope.data = {};

      $scope.getAccountId = function () {
        return query.get('id');
      };

      $scope.isNewAccount = $scope.getAccountId() === null;

      $scope.$on('reloadAccountData', function (e) {
        $scope.reload();
      });

      $scope.reload = function () {
        $scope.isNewAccount = $scope.getAccountId() === null;

        $scope.accountUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getAccountId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Account.detail({id: $scope.getAccountId()}, function (account) {
            $scope.data = account;
            hash = account.hash;

            $scope.$broadcast('accountDataReloaded', account);
          });
        }
      };

      $timeout($scope.reload);
      $timeout(checkAccountUpdate, 5000);

      $scope.accountUpdatedWarning = false;

      function checkAccountUpdate() {
        if ($scope.getAccountId() !== null) {
          Account.detail({id: $scope.getAccountId()}, function (account) {
            if (hash !== account.hash) {
              $scope.accountUpdatedWarning = true;
            }
          });

          $timeout(checkAccountUpdate, 5000);
        }
      }
    }
  ]);