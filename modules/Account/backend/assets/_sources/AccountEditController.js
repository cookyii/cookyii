"use strict";

angular.module('BackendApp')

  .controller('AccountEditController', [
    '$scope', '$http', '$location', '$timeout', 'ToastScope', 'UdpWebSocket',
    function ($scope, $http, $location, $timeout, ToastScope, UdpWebSocket) {

      $scope.inProgress = false;

      $scope.submit = function (AccountEditForm, e) {
        var $form = angular.element('#AccountEditForm');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            account_id: $scope.$parent.getAccountId(),
            AccountEditForm: $scope.data
          }
        })
          .success(function (response) {
            if (response.result === false) {
              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                ToastScope.send('error', {
                  message: 'Save error'
                });
              }
            } else {
              ToastScope.send('success', {
                message: 'Account successfully saved'
              });

              if ($scope.$parent.isNewAccount) {
                $location.search('id', response.account_id);
              }

              UdpWebSocket.send('reload-account-' + response.account_id);

              $scope.reload();
            }
          })
          .error(function (response) {
            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              ToastScope.send('error', {
                message: 'Error updating account'
              });
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };
    }
  ]);