"use strict";

angular.module('BackendApp')

  .controller('ClientEditController', [
    '$scope', '$http', '$location', '$timeout', 'ToastScope',
    function ($scope, $http, $location, $timeout, ToastScope) {

      $scope.inProgress = false;

      $scope.submit = function (ClientEditForm, e) {
        var $form = angular.element('#ClientEditForm');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            client_id: $scope.$parent.getClientId(),
            ClientEditForm: $scope.data
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
                message: 'Client successfully saved'
              });

              if ($scope.$parent.isNewClient) {
                $location.search('id', response.client_id);
              }

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
                message: 'Error updating client'
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