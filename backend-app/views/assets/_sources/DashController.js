angular
  .module('BackendApp')

  .controller('DashController', function ($scope, $timeout, $mdToast, $mdSidenav, $mdUtil, $log) {
    $scope.toggleSidePanel = buildToggler('side-panel');
    /**
     * Build handler to open/close a SideNav; when animation finishes
     * report completion in console
     */
    function buildToggler(navID) {
      return $mdUtil.debounce(function () {
        $mdSidenav(navID).toggle();
      }, 300);
    }

    $scope.t = function () {
      toast($mdToast, 'success', {
        message: 'Click'
      });
    };
  })

  .controller('RightCtrl', function ($scope, $timeout, $mdSidenav, $log) {
    $scope.close = function () {
      $mdSidenav('side-panel').close();
    };
  });