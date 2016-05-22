angular
  .module('CrmApp')

  .controller('DashController', [
    '$scope', '$timeout', 'ToastrScope',
    function ($scope, $timeout, ToastrScope) {

      var toastr = ToastrScope($scope);

      $scope.t = function () {
        toastr.success('Click');
      };
    }]);