"use strict";

angular.module('scopes')

  .factory('FilterSearchScope', [
    'QueryScope',
    function (QueryScope) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope);

        $scope.query = query.get('search');

        $scope.do = function () {
          query.set('search', $scope.query);

          if (typeof $scope.query === 'string' && $scope.query.length > 0) {
            $scope.reload();
          }
        };

        $scope.clear = function () {
          $scope.query = null;

          $scope.do();
        };

        return $scope;
      }
    }
  ]);