"use strict";

angular.module('BackendApp')

  .factory('feed.list.ItemListScope', [
    '$timeout', 'QueryScope', 'SortScope', 'ToastrScope', 'feed.list.FilterScope', 'feed.ItemResource',
    function ($timeout, QueryScope, SortScope, ToastrScope, FilterScope, Item) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope),
          toastr = ToastrScope($scope),
          page = query.get('page', 1),
          loaded = false;

        $scope.sort = SortScope($scope);
        $scope.filter = FilterScope($scope);

        $scope.lsit = [];

        $scope.inProgress = false;

        $scope.pagination = {
          currentPage: page
        };

        $scope.doPageChanged = function () {
          if (loaded === true) {
            query.set('page', $scope.pagination.currentPage);
          }

          _refresh();
        };

        $scope.toggleActivation = function (item) {
          $timeout(function () {
            if (item.activated === true) {
              item.$activate(_refresh, _refresh);
            } else {
              item.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
          var section = $scope.filter.section.getSelected(),
            section_id = section === null ? null : section.id;

          location.href = '/feed/item/edit#?section=' + section_id;
        };

        $scope.edit = function (item) {
          location.href = '/feed/item/edit#?id=' + item.id;
        };

        $scope.remove = function (item, e) {
          swal({
            type: "warning",
            title: "Would you like to delete this item?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
            item.$remove(function () {
              toastr.success('Item successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing item');
            });
          });
        };

        $scope.restore = function (item) {
          item.$restore(function () {
            toastr.success('Item successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring item');
          });
        };

        $scope.reload = function () {
          if ($scope.filter.section.selected === null) {
            $scope.list = [];

            return;
          }

          $scope.inProgress = true;

          Item.query({
            deactivated: $scope.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            section: $scope.filter.section.selected,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page,
            expand: 'picture_300,created_at,updated_at'
          }, function (response, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = response;

            loaded = true;

            $scope.inProgress = false;
          });
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);