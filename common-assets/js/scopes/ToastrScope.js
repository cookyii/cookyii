"use strict";

angular.module('scopes')

  .factory('ToastrScope', [
    'toastr',
    function (toastr) {
      return function ($parentScope) {
        var $scope = $parentScope.$new();

        $scope.error = function (text, title, options) {
          toastr.error(text, title, options);
        };

        $scope.warning = function (text, title, options) {
          toastr.warning(text, title, options);
        };

        $scope.success = function (text, title, options) {
          toastr.success(text, title, options);
        };

        $scope.info = function (text, title, options) {
          toastr.info(text, title, options);
        };

        $scope.response = {
          error: function (response, options) {
            $scope.error(response.text, response.title, options);
          },
          warning: function (response, options) {
            $scope.warning(response.text, response.title, options);
          },
          success: function (response, options) {
            $scope.success(response.text, response.title, options);
          },
          info: function (response, options) {
            $scope.info(response.text, response.title, options);
          }
        };

        $scope.defaultFormErrorHandler = function (response, errors, showMessage) {
          showMessage = typeof showMessage === 'undefined' ? true : showMessage;

          if (typeof errors !== 'undefined') {
            errors = jQuery.parseJSON(errors);
            angular.forEach(errors, function (text, key) {
              $parentScope.error[key] = text;
            });
          }

          if (showMessage) {
            var message = typeof response.message === 'undefined' ? response : response.message;

            try {
              $scope.response.warning(jQuery.parseJSON(message));
            } catch (e) {
              $scope.warning(message);
            }
          }
        };

        return $scope;
      };
    }
  ]);