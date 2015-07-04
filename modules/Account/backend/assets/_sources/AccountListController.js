"use strict";

angular.module('BackendApp')

  .controller('AccountListController', [
    '$scope', '$http', '$timeout', 'ToastScope', '$mdDialog', '$location', 'AccountResource',
    function ($scope, $http, $timeout, ToastScope, $mdDialog, $location, Account) {
      var query = $location.search(),
        loaded = false,
        refreshInterval = 5000;

      var page = typeof query.page === 'undefined'
        ? 1
        : query.page;

      $scope.accounts = [];

      function _refresh() {
        reloadAccountList(false);
      }

      $timeout(reloadAccountList);

      $scope.toggleActivated = function (account) {
        $timeout(function () {
          if (account.activated === 1) {
            account.$activate(_refresh, _refresh);
          } else {
            account.$deactivate(_refresh, _refresh);
          }
        }, 400);
      };

      $scope.deleted = typeof query.deleted === 'undefined'
        ? false
        : query.deleted === 'true';

      $scope.toggleDeleted = function () {
        $scope.deleted = !$scope.deleted;

        $location.search('deleted', $scope.deleted === true ? 'true' : 'false');

        _refresh();
      };

      $scope.searchFocus = false;
      $scope.search = typeof query.search === 'undefined'
        ? null
        : query.search;

      $scope.doSearch = function () {
        $scope.searchFocus = false;

        $location.search('search', $scope.search);

        _refresh();
      };

      $scope.toggleSearchFocus = function () {
        $scope.searchFocus = true;
      };

      $scope.clearSearch = function () {
        $scope.search = null;
        $scope.doSearch();
      };

      $scope.pagination = {
        currentPage: page
      };

      $scope.doPageChanged = function () {
        if (loaded === true) {
          $location.search('page', $scope.pagination.currentPage);
        }

        _refresh();
      };

      $scope.sort = typeof query.sort === 'undefined'
        ? '-id'
        : query.sort;

      $scope.setSort = function (sort) {
        if ($scope.sort === sort) {
          $scope.sort = '-' + sort;
        } else {
          $scope.sort = sort;
        }

        $location.search('sort', $scope.sort);

        _refresh();
      };

      $scope.addAccount = function () {
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
            ToastScope.send('success', {
              message: 'Account successfully removed'
            });

            _refresh();
          }, function () {
            ToastScope.send('error', {
              message: 'Error removing account'
            });
          });
        });
      };

      $scope.restore = function (account) {
        account.$restore(function () {
          ToastScope.send('success', {
            message: 'Account successfully restored'
          });

          _refresh();
        }, function () {
          ToastScope.send('error', {
            message: 'Error restoring account'
          });
        });
      };

      function reloadAccountList(setTimeout) {
        if ($scope.searchFocus === true) {
          $timeout(reloadAccountList, refreshInterval);

          return;
        }

        setTimeout = typeof setTimeout === 'boolean'
          ? setTimeout
          : true;

        Account.query({
          deactivated: $scope.deactivated,
          deleted: $scope.deleted,
          search: $scope.search,
          sort: $scope.sort,
          page: loaded ? $scope.pagination.currentPage : page
        }, function (accounts, headers) {
          var _headers = headers();

          $scope.pagination = {
            totalCount: _headers['x-pagination-total-count'],
            pageCount: _headers['x-pagination-page-count'],
            currentPage: _headers['x-pagination-current-page'],
            perPage: _headers['x-pagination-per-page']
          };

          $scope.accounts = accounts;

          if (setTimeout) {
            $timeout(reloadAccountList, refreshInterval);
          }

          loaded = true;
        });
      }
    }
  ]);