angular
  .module('CrmApp')

  .controller('DashController', [
    '$scope', '$timeout', 'ToastrScope', '$mdSidenav', '$mdUtil',
    function ($scope, $timeout, ToastrScope, $mdSidenav, $mdUtil) {

      var toastr = ToastrScope($scope);

      $scope.toggleSidePanel = buildToggler('side-panel');

      function buildToggler(navID) {
        return $mdUtil.debounce(function () {
          $mdSidenav(navID).toggle();
        }, 300);
      }

      $scope.t = function () {
        toastr.success('Click');
      };
    }])

  .controller('RightCtrl', [
    '$scope', '$timeout', '$mdSidenav',
    function ($scope, $timeout, $mdSidenav) {
      $scope.close = function () {
        $mdSidenav('side-panel').close();
      };
    }]);