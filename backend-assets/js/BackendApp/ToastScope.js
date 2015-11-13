"use strict";

angular.module('BackendApp')

  .factory('ToastScope', [
    '$rootScope', '$mdToast',
    function ($rootScope, $mdToast) {
      var
        $scope = $rootScope.$new();

      $scope.send = function (type, scope) {
        $scope.show({
          templateUrl: 'toast-' + type + '.html',
          controller: ['$scope', function ($scope) {
            $scope.action = 'ОК';
            $scope.resolve = function () { $mdToast.hide(); }

            $scope = angular.extend($scope, scope);
          }],
          bindToController: true
        });
      };

      $scope.show = function (options) {
        var defaultOptions = {
          hideDelay: 15000,
          position: 'bottom right'
        };

        options = angular.extend({}, defaultOptions, options);

        $mdToast.show(options);
      };

      return $scope;
    }
  ]);