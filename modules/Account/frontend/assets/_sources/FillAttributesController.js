"use strict";

angular.module('FrontendApp')

  .controller('FillAttributesController', [
    '$scope', '$http', 'ToastrScope',
    function ($scope, $http, ToastrScope) {
      var _config = {},
        defaultValues = {
          email: null
        },
        defaultErrors = {};

      var toastr = ToastrScope($scope);

      $scope.in_progress = false;

      $scope.init = function (config) {
        _config = angular.extend({}, _config, config);
      };

      resetData();
      resetErrors();

      $scope.submit = function (SignInForm, e) {
        var $form = angular.element(e.target);

        $scope.in_progress = true;
        resetErrors();

        $http({
          method: 'POST',
          url: $form.prop('action'),
          data: jQuery.param({
            _csrf: angular.element('meta[name="csrf-token"]').attr('content'),
            FillAttributesForm: $scope.data
          }),
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          }
        })
          .then(function (response) {
            if (true === response.data.result) {
              location.href = response.data.redirect;
            } else {
              if (typeof response.data.errors !== 'undefined') {
                $scope.error = response.data.errors;
              } else {
                toastr.error(response.data.message);
              }
            }
          }, function (response) {
            toastr.error(response.data.message);
          })
          .finally(function () {
            $scope.in_progress = false;
          });

        e.preventDefault();
      };

      function resetData() {
        $scope.data = angular.copy(defaultValues);
      }

      function resetErrors() {
        $scope.error = angular.copy(defaultErrors);
      }
    }
  ]);