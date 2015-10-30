"use strict";

angular.module('BackendApp')

  .service('FilterScope', [
    'QueryScope',
    function (QueryScope) {
      return function ($parentScope) {
        var $scope = $parentScope.$new();

        $scope.translated = QueryScope.get('translated', false);

        $scope.toggleTranslated = function () {
          $scope.translated = !$scope.translated;

          QueryScope.set('translated', $scope.translated === true ? 'true' : 'false');
        };

        $scope.selectedCategory = QueryScope.get('category');

        $scope.setCategory = function (category) {
          $scope.selectedCategory = category;

          QueryScope.set('category', $scope.selectedCategory);
        };

        return $scope;
      }
    }
  ]);