"use strict";

angular.module('CrmApp')

  .factory('client.list.ListScope', [
    '$timeout', 'QueryScope', 'ToastrScope', 'SortScope', 'client.list.FilterScope', 'client.ClientResource',
    function ($timeout, QueryScope, ToastrScope, SortScope, FilterScope, Client) {
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

        $scope.toggleActivated = function (client) {
          $timeout(function () {
            if (client.activated === true) {
              client.$activate(_refresh, _refresh);
            } else {
              client.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
          location.href = '/client/edit';
        };

        $scope.edit = function (client) {
          location.href = '/client/edit#?id=' + client.id;
        };

        $scope.remove = function (client, e) {
          swal({
            type: "warning",
            title: "Would you like to delete this client?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
            client.$remove(function () {
              toastr.success('Client successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing client');
            });
          });
        };

        $scope.restore = function (client) {
          client.$restore(function () {
            toastr.success('Client successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring client');
          });
        };

        $scope.reload = function () {
          $scope.inProgress = true;

          Client.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page,
            expand: 'account'
          }, function (clients, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = clients;

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