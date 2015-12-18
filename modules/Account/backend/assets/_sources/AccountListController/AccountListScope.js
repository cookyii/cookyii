"use strict";

angular.module('BackendApp')

  .factory('AccountListScope', [
    '$timeout', '$mdDialog', 'QueryScope', 'ToastrScope', 'SortScope', 'FilterScope', 'AccountResource',
    function ($timeout, $mdDialog, QueryScope, ToastrScope, SortScope, FilterScope, Account) {
      return function ($parentScope) {
        var $scope = $parentScope.$new(),
          toastr = ToastrScope($scope),
          page = QueryScope.get('page', 1),
          loaded = false;

        $scope.sort = SortScope($scope);
        $scope.filter = FilterScope($scope);

        $scope.list = [];

        $scope.pagination = {
          currentPage: page
        };

        $scope.doPageChanged = function () {
          if (loaded === true) {
            QueryScope.set('page', $scope.pagination.currentPage);
          }

          _refresh();
        };

        $scope.toggleActivated = function (account) {
          $timeout(function () {
            if (account.activated === true) {
              account.$activate(_refresh, _refresh);
            } else {
              account.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
          location.href = '/account/edit';
        };

        $scope.edit = function (account) {
          location.href = '/account/edit#?id=' + account.id;
        };

        $scope.remove = function (account, e) {
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to delete this account?')
            .ok('Please do it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            account.$remove(function () {
              toastr.success('Account successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing account');
            });
          });
        };

        $scope.restore = function (account) {
          account.$restore(function () {
            toastr.success('Account successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring account');
          });
        };

        var reloadTimeout;

        $scope.reload = function () {
          Account.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page
          }, function (accounts, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = accounts;

            $timeout.cancel(reloadTimeout);
            reloadTimeout = $timeout($scope.reload, 5000);

            loaded = true;
          });
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);