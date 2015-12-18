"use strict";

angular.module('BackendApp')

  .factory('FilterSectionScope', [
    '$timeout', '$mdDialog', 'ToastrScope', 'QueryScope', 'SectionResource',
    function ($timeout, $mdDialog, ToastrScope, QueryScope, Section) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          toastr = ToastrScope($scope);

        $scope.selected = QueryScope.get('section');

        $scope.list = {};
        $scope.tree = [];

        $scope.get = function (slug) {
          return typeof $scope.list[slug] === 'undefined' ? null : $scope.list[slug];
        };

        $scope.getSelected = function () {
          return $scope.get($scope.selected);
        };

        $scope.add = function () {
          var parent = $scope.selected === null ? null : $scope.sections[$scope.selected].id;

          location.href = '/feed/section/edit#?parent=' + parent;
        };

        $scope.edit = function (section) {
          location.href = '/feed/section/edit#?section=' + section;
        };

        $scope.select = function (section) {
          if ($scope.selected === section.slug) {
            $scope.selected = null;
          } else {
            $scope.selected = section.slug;
          }

          QueryScope.set('section', $scope.selected);

          _refresh();
        };

        $scope.isActive = function (section) {
          return section.contain.indexOf($scope.selected) > -1;
        };

        $scope.remove = function (section, e) {
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to delete this section?')
            .ok('Please do it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            Section.remove({slug: section}, function () {
              toastr.success('Section successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing section');
            });
          });
        };

        $scope.restore = function (section) {
          Section.restore({slug: section}, function () {
            toastr.success('Section successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring section');
          });
        };

        var reloadTimeout;

        $scope.reload = function () {
          if ($scope.searchFocus === true) {
            $timeout($scope.reload, 5000);

            return;
          }

          Section.tree({
            deleted: $parentScope.deleted
          }, function (response) {
            $scope.tree = response.sections;
            $scope.list = response.models;

            $timeout.cancel(reloadTimeout);
            reloadTimeout = $timeout($scope.reload, 5000);
          });
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);