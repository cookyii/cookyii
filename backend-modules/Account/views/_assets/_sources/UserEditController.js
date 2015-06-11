"use strict";

angular.module('BackendApp')

  .controller('UserEditController', [
    '$rootScope', '$scope', '$element', '$http', '$mdToast',
    function ($rootScope, $scope, $modal, $http, $mdToast) {
      var _config = {},
        defaultValues = {
          roles: [],
          activated: true,
          deleted: false
        },
        defaultErrors = {};

      $scope.in_progress = false;

      $scope.init = function (config) {
        _config = angular.extend({}, _config, config);
      };

      resetData();
      resetErrors();

      $scope.submit = function (e) {
        $scope.in_progress = true;
        resetErrors();

        $http({
          method: 'POST',
          url: _config.url.edit,
          params: {user: $rootScope.edit_account_id},
          data: {
            _csrf: angular.element('meta[name="csrf-token"]').attr('content'),
            AccountEditForm: $scope.data
          }
        })
          .success(function (response) {
            if (true === response.result) {
              toast($mdToast, 'success', {
                message: response.message
              });

              $modal.modal('hide');
              $rootScope.$broadcast('ListRefresh');
            } else {
              if (typeof response.errors !== 'undefined') {
                $scope.error = response.errors;
              } else {
                toast($mdToast, 'error', {
                  message: response.message
                });
              }
            }
          })
          .error(defaultHttpErrorHandler)
          .finally(function () {
            $scope.in_progress = false;
          });

        e.preventDefault();
      };

      $modal.find('#AccountEditForm').bind('reset', function (e) {
        $modal.modal('hide');
        e.preventDefault();
      });

      $modal.bind('show.bs.modal', function () {
        var user_id = $rootScope.edit_account_id;

        resetData();
        resetErrors();

        if (user_id === null) {
          $scope.data.roles.user = true;
        } else {
          $http({
            method: 'GET',
            url: _config.url.get,
            data: {},
            params: {
              user: user_id
            },
            ignoreLoadingBar: true
          }).success(function (response) {
            $scope.data = response;

            var roles = angular.copy($scope.data.roles);
            $scope.data.roles = {};

            angular.forEach(roles, function (label, key) {
              $scope.data.roles[key] = true;
            });
            $scope.data.roles.user = true;

          }).error(defaultHttpErrorHandler);
        }
      });

      function resetData() {
        $scope.data = angular.copy(defaultValues);
      }

      function resetErrors() {
        $scope.error = angular.copy(defaultErrors);
      }
    }
  ]);