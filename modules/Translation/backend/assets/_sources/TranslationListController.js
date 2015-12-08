"use strict";

angular.module('BackendApp')

  .controller('TranslationListController', [
    '$scope', '$timeout', '$http', 'FilterScope',
    function ($scope, $timeout, $http, FilterScope) {

      $scope.filter = FilterScope($scope);

      $scope.languages = [];
      $scope.phrases = [];

      var focus = {};
      $scope.focus = function (phrase) {
        focus[phrase] = true;
      };

      $scope.isFullTranslatedPhrase = function (phrase, variants) {
        var result = true;
        angular.forEach(variants, function (item, key) {
          if (
            ($scope.filter.isAllLanguagesSelected() || $scope.filter.isLanguageSelect(key))
            && (result && item === null)
            || typeof focus[phrase] !== 'undefined') {
            result = false;
          }
        });

        return result;
      };

      $scope.save = function (e, category, phrase, variants, language) {
        if (angular.element(e.target).hasClass('ng-dirty')) {
          $http({
            method: 'POST',
            url: '/translation/api/save',
            data: {
              category: category,
              phrase: phrase,
              variants: variants
            }
          }).then(function (response) {
            var key = buildResultKey(category, phrase, language);
            saveResult[key] = response.data;
            $timeout(function () {
              delete saveResult[key];
            }, 5000);
          });
        }
      };

      var saveResult = {};
      $scope.saveResult = function (category, phrase, variants, language) {
        var key = buildResultKey(category, phrase, language);

        return {
          success: saveResult[key] === true,
          dander: saveResult[key] === false
        };
      };

      function buildResultKey(category, phrase, language) {
        return category + ':' + phrase + ':' + language;
      }

      $http.reload = function () {
        $http({
          method: 'GET',
          url: '/translation/api/phrases'
        }).then(function (response) {
          $scope.languages = response.data.languages;
          $scope.phrases = response.data.items;

          angular.forEach($scope.phrases, function (phrases, dict) {
            if ($scope.filter.selectedCategory === null) {
              $scope.filter.setCategory(dict);
            }
          });
        });
      };

      $timeout($http.reload);
    }
  ]);