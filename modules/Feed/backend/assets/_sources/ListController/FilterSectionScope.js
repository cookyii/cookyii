"use strict";

angular.module('BackendApp')

  .factory('feed.list.FilterSectionScope', [
    '$timeout', 'ToastrScope', 'QueryScope', 'feed.SectionResource',
    function ($timeout, ToastrScope, QueryScope, Section) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope),
          toastr = ToastrScope($scope);

        $scope.selected = query.get('section');

        $scope.list = {};
        $scope.tree = [];

        $scope.get = function (slug) {
          return typeof $scope.list[slug] === 'undefined' ? null : $scope.list[slug];
        };

        $scope.getSelected = function () {
          return $scope.get($scope.selected);
        };

        $scope.add = function () {
          var parent = $scope.selected === null ? null : $scope.list[$scope.selected].id;

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

          query.set('section', $scope.selected);

          _refresh();
        };

        $scope.isActive = function (section) {
          return section.contain.indexOf($scope.selected) > -1;
        };

        $scope.remove = function (section, e) {
          swal({
            type: "warning",
            title: "Would you like to delete this section?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
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
          });
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);