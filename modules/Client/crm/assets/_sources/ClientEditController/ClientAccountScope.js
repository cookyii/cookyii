"use strict";

angular.module('CrmApp')

  .factory('ClientAccountScope', [
    '$timeout', '$mdDialog', '$http', 'ToastrScope',
    function ($timeout, $mdDialog, $http, ToastrScope) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          toastr = ToastrScope($scope);

        $scope.create = function (e) {
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to create user account for this client?')
            .ok('Please do it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            $parentScope.error = {};

            $parentScope.inProgress = true;

            $http({
              method: 'POST',
              url: angular.element(e.target).data('action'),
              data: {
                _csrf: yii.getCsrfToken(),
                client_id: $parentScope.$parent.getClientId()
              }
            })
              .success(function (response) {
                if (response.result === false) {
                  if (typeof response.errors !== 'undefined') {
                    angular.forEach(response.errors, function (message, field) {
                      $parentScope.error[field] = message;
                    });
                  } else {

                    toastr.error(response.message);
                  }
                } else {
                  toastr.success(response.message);

                  $parentScope.reload();
                }
              })
              .error(function (response) {
                toastr.error(response.message.length > 0 ? response.message : response.name);
              })
              .finally(function () {
                $parentScope.inProgress = false;
              });
          });
        };

        $scope.unlink = function (e) {
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to unlink user account from this client?')
            .ok('Please do it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            $parentScope.error = {};

            $parentScope.inProgress = true;

            $http({
              method: 'POST',
              url: angular.element(e.target).data('action'),
              data: {
                _csrf: yii.getCsrfToken(),
                client_id: $parentScope.$parent.getClientId()
              }
            })
              .success(function (response) {
                if (response.result === false) {
                  if (typeof response.errors !== 'undefined') {
                    angular.forEach(response.errors, function (message, field) {
                      $parentScope.error[field] = message;
                    });
                  } else {
                    toastr.error(response.message);
                  }
                } else {
                  toastr.success(response.message);

                  $parentScope.reload();
                }
              })
              .error(function (response) {
                toastr.error(response.message.length > 0 ? response.message : response.name);
              })
              .finally(function () {
                $parentScope.inProgress = false;
              });
          });
        };

        return $scope;
      }
    }
  ]);