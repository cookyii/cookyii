"use strict";

angular.module('CrmApp')

  .controller('client.EditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'ToastrScope', 'client.edit.AccountScope',
    function ($scope, $http, $timeout, QueryScope, ToastrScope, AccountScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.error = {};
      $scope.account = AccountScope($scope);

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
          .then(function (response) {
            if (response.data.result === false) {
              if (typeof response.data.errors !== 'undefined') {
                angular.forEach(response.data.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toastr.error('Save error');
              }
            } else {
              toastr.success('Client successfully saved');

              if ($scope.$parent.isNewClient) {
                query.set('id', response.data.client_id);
              }

              $scope.reload();
            }
          }, function (response) {
            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating client');
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };
    }
  ]);