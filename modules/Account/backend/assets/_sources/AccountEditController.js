"use strict";

angular.module('BackendApp')

  .controller('AccountEditController', [
    '$scope', '$http', '$location', 'ToastrScope',
    function ($scope, $http, $location, ToastrScope) {

      var toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.submit = function (Form, e) {
        var $form = angular.element('form[name="' + Form.$name + '"]');

        console.log($scope.$parent.data);

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
          .success(function (response) {
            if (response.result === false) {
              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toastr.error('Save error');
              }
            } else {
              toastr.success('Account successfully saved');

              if ($scope.$parent.isNewAccount) {
                $location.search('id', response.account_id);
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