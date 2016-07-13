"use strict";

angular.module('cookyii.scopes')

  .factory('TabScope', [
    '$timeout', 'QueryScope',
    function ($timeout, QueryScope) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(true),
          query = QueryScope($scope);

        $scope.selected = parseInt(query.get('tab', 0));

        $scope.$watch('selected', function (tab) {
          query.set('tab', tab);

          $timeout(function () {
            jQuery(window).trigger('resize');
          });
        });

        return $scope;
      }
    }
  ]);