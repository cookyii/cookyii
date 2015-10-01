"use strict";

angular.module('BackendApp')

  .factory('SectionDropdownScope', [
    '$rootScope', '$timeout', 'SectionResource',
    function ($rootScope, $timeout, Section) {
      var $scope = $rootScope.$new();

      $scope.list = [];

      $scope.checkCurrentSection = function (slug, mark) {
        mark = typeof mark !== 'string' ? ' *' : mark;

        angular.forEach($scope.list, function (section, index) {
          if (section.slug === slug) {
            $scope.list[index].label += mark;
            $scope.list[index].disable = true;
          }
        });
      };

      $scope.reload = function (addRoot, callback) {
        addRoot = typeof addRoot === 'boolean'
          ? addRoot
          : true;

        Section.tree(function (response) {
          $scope.list = [];

          if (addRoot) {
            $scope.list.push({
              id: null,
              slug: null,
              label: 'Root section',
              disable: false
            });
          }

          appendSections(response, 1);

          if (typeof callback === 'function') {
            callback();
          }

          $timeout(function () {
            $scope.reload(addRoot, callback);
          }, 30000);
        });
      };

      function appendSections(data, indent) {
        if (typeof data !== 'undefined' && typeof data.sections !== 'undefined' && data.sections.length > 0) {
          angular.forEach(data.sections, function (section) {
            $scope.list.push({
              id: section.id,
              slug: section.slug,
              label: str_repeat('....', indent) + ' ' + section.title,
              disable: false
            });

            if (typeof section.sections !== 'undefined' && section.sections.length > 0) {
              appendSections(section, indent + 1);
            }
          });
        }
      }

      return $scope;
    }
  ]);