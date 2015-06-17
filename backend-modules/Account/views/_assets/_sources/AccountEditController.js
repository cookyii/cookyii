"use strict";

angular.module('BackendApp')

  .controller('AccountEditController', [
    '$scope', '$location', '$http', '$timeout', '$mdToast', '$mdDialog', 'UserResource',
    function ($scope, $location, $http, $timeout, $mdToast, $mdDialog, User) {
      var hash = null,
        query = $location.search(),
        defaultValues = {
          roles: []
        },
        user_id;

      user_id = typeof query.id === 'undefined'
        ? null
        : parseInt(query.id);

      $scope.inProgress = false;

      $scope.$on('reloadUserData', function (e) {
        $scope.reload();
      });

      $scope.reload = function () {
        $scope.userUpdatedWarning = false;
        $scope.editedProperty = null;

        if (user_id === null) {
          $scope.data = angular.copy(defaultValues);
        }

        User.detail({user: user_id}, function (user) {
          $scope.data = user;
          hash = user.hash;

          $scope.$broadcast('userDataReloaded', user);
        });
      };

      $scope.submit = function (e) {
        var $form = angular.element('#AccountEditForm');

        $scope.error = {};
        $scope.inProgress = true;

        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            user_id: user_id,
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
                toast($mdToast, 'error', {
                  message: 'Error updating account'
                });
              }
            } else {
              toast($mdToast, 'success', {
                message: 'Account successfully updated'
              });

              $scope.reload();
            }
          })
          .error(function (response) {
            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toast($mdToast, 'error', {
                message: 'Error updating account'
              });
            }
          })
          .finally(function(){
            $scope.inProgress = false;
          });

        e.preventDefault();
      };

      $scope.userUpdatedWarning = false;

      $timeout($scope.reload);
      $timeout(checkUserUpdate, 5000);

      function checkUserUpdate() {
        User.detail({user: user_id}, function (user) {
          if (hash !== user.hash) {
            userUpdatedWarning();
          }
        });

        $timeout(checkUserUpdate, 5000);
      }

      function userUpdatedWarning() {
        $scope.userUpdatedWarning = true;
      }
    }
  ]);