angular
  .module('BackendApp')

  .controller('DashController', [
    '$scope', '$timeout', 'ToastScope', '$mdSidenav', '$mdUtil',
    function ($scope, $timeout, ToastScope, $mdSidenav, $mdUtil) {
      $scope.toggleSidePanel = buildToggler('side-panel');

      function buildToggler(navID) {
        return $mdUtil.debounce(function () {
          $mdSidenav(navID).toggle();
        }, 300);
      }

      $scope.t = function () {
        ToastScope.send('success', {
          message: 'Click'
        });
      };
    }])

  .controller('RightCtrl', [
    '$scope', '$timeout', '$mdSidenav',
    function ($scope, $timeout, $mdSidenav) {
      $scope.close = function () {
        $mdSidenav('side-panel').close();
      };
    }]);