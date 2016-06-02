"use strict";

angular.module('BackendApp')

  .factory('client.edit.AccountScope', [
    '$timeout', '$http', 'ToastrScope',
    function ($timeout, $http, ToastrScope) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          toastr = ToastrScope($scope);

        $scope.create = function (e) {
          swal({
            type: "warning",
            title: "Would you like to create user account for this client?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
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
              .then(function (response) {
                if (response.data.result === false) {
                  if (typeof response.data.errors !== 'undefined') {
                    angular.forEach(response.data.errors, function (message, field) {
                      $parentScope.error[field] = message;
                    });
                  } else {

                    toastr.error(response.data.message);
                  }
                } else {
                  toastr.success(response.data.message);

                  $parentScope.reload();
                }
              }, function (response) {
                toastr.error(response.data.message.length > 0 ? response.data.message : response.data.name);
              })
              .finally(function () {
                $parentScope.inProgress = false;
              });
          });
        };

        $scope.unlink = function (e) {
          swal({
            type: "warning",
            title: "Would you like to unlink user account from this client?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
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
              .then(function (response) {
                if (response.data.result === false) {
                  if (typeof response.data.errors !== 'undefined') {
                    angular.forEach(response.data.errors, function (message, field) {
                      $parentScope.error[field] = message;
                    });
                  } else {
                    toastr.error(response.data.message);
                  }
                } else {
                  toastr.success(response.data.message);

                  $parentScope.reload();
                }
              }, function (response) {
                toastr.error(response.data.message.length > 0 ? response.data.message : response.data.name);
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