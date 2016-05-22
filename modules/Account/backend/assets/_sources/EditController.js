"use strict";

angular.module('BackendApp')

  .controller('account.EditController', [
    '$scope', '$http', 'QueryScope', 'ToastrScope',
    function ($scope, $http, QueryScope, ToastrScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.submit = function (Form, e) {
        var $form = angular.element('form[name="' + Form.$name + '"]');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            account_id: $scope.$parent.getAccountId(),
            FormData: $scope.$parent.data
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
              toastr.success('Account successfully saved');

              if ($scope.$parent.isNewAccount) {
                query.set('id', response.data.account_id);
              }

              $scope.reload();
            }
          }, function (response) {
            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating account');
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      };
    }
  ]);