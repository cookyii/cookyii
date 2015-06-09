function defaultHttpErrorHandler(error, status) {
  if (typeof error !== 'undefined') {
    console.log('Error ' + status, error.message);
  } else {
    console.log('Unknown Error');
  }
}

function toast($mdToast, type, scope) {
  $mdToast.show({
    templateUrl: 'toast-' + type + '.html',
    controller: ['$scope', function ($scope) {
      $scope.action = 'ОК';
      $scope.resolve = function () { $mdToast.hide(); }

      $scope = angular.extend($scope, scope);
    }],
    hideDelay: 15000,
    position: 'bottom right',
    bindToController: true
  });
}