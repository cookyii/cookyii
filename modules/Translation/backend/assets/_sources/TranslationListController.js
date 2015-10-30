"use strict";

angular.module('BackendApp')

  .controller('TranslationListController', [
    '$scope', '$timeout', '$http', 'FilterScope',
    function ($scope, $timeout, $http, FilterScope) {

      $scope.filter = FilterScope($scope);

      $scope.languages = [];
      $scope.phrases = [];

      $scope.save = function (category, phrase, variants) {
        $http({
          method: 'POST',
          url: '/translation/api/save',
          data: {
            category: category,
            phrase: phrase,
            variants: variants
          }
        }).then(function (response) {
          console.log(response.data);
        });
      };

      $http.reload = function () {
        $http({
          method: 'GET',
          url: '/translation/api/phrases'
        }).then(function (response) {
          $scope.languages = response.data.languages;
          $scope.phrases = response.data.items;
          console.log($scope.languages);
          console.log($scope.phrases);
        });
      };

      $timeout($http.reload);
    }
  ]);