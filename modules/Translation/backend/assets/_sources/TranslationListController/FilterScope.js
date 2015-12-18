"use strict";

angular.module('BackendApp')

  .service('FilterScope', [
    'QueryScope',
    function (QueryScope) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope);

        $scope.translated = query.get('translated', true);

        $scope.toggleTranslated = function () {
          $scope.translated = !$scope.translated;

          query.set('translated', $scope.translated === true ? 'true' : 'false');
        };

        var languages = query.get('languages', '');
        languages = languages.length > 0
          ? languages.split(',')
          : null;

        $scope.languages = languages;

        $scope.toggleLanguage = function (language) {
          var result = [],
            removed = false;

          if (typeof language !== 'undefined') {
            angular.forEach(languages, function (lang, key) {
              if (lang === language) {
                removed = true;
                delete languages[key];
              } else {
                result.push(lang);
              }
            });

            if (removed === false) {
              result.push(language);
            }
          }

          languages = result;

          query.set('languages', languages.join(','));
        };

        $scope.isAllLanguagesSelected = function () {
          return languages === null || languages.length === 0;
        };

        $scope.isLanguageSelect = function (language) {
          return !$scope.isAllLanguagesSelected() && languages.indexOf(language) > -1;
        };

        $scope.selectedCategory = query.get('category');

        $scope.setCategory = function (category) {
          $scope.selectedCategory = category;

          query.set('category', $scope.selectedCategory);
        };

        return $scope;
      }
    }
  ]);