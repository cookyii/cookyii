"use strict";

angular.module('BackendApp')

  .factory('page.list.ListScope', [
    '$timeout', 'ToastrScope', 'QueryScope', 'SortScope', 'page.list.FilterScope', 'page.PageResource',
    function ($timeout, ToastrScope, QueryScope, SortScope, FilterScope, Page) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope),
          toastr = ToastrScope($scope),
          page = query.get('page', 1),
          loaded = false;

        $scope.sort = SortScope($scope);
        $scope.filter = FilterScope($scope);

        $scope.list = [];

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

        $scope.toggleActivated = function (page) {
          $timeout(function () {
            if (page.activated === true) {
              page.$activate(_refresh, _refresh);
            } else {
              page.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
          location.href = '/page/edit';
        };

        $scope.edit = function (page) {
          location.href = '/page/edit#?id=' + page.id;
        };

        $scope.remove = function (page, e) {
          swal({
            type: "warning",
            title: "Would you like to delete this page?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
            page.$remove(function () {
              toastr.success('Page successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing page');
            });
          });
        };

        $scope.restore = function (page) {
          page.$restore(function () {
            toastr.success('Page successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring page');
          });
        };

        $scope.reload = function () {
          $scope.inProgress = true;

          Page.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page,
            expand: 'created_at,updated_at'
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