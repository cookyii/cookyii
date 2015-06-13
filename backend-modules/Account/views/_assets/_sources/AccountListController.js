"use strict";

angular.module('BackendApp')

  .controller('AccountListController', [
    '$scope', '$http', '$timeout', '$mdToast', '$mdDialog', '$location', 'UserResource',
    function ($scope, $http, $timeout, $mdToast, $mdDialog, $location, User) {
      var query = $location.search(),
        loaded = false,
        refreshInterval = 5000;

      var page = typeof query.page === 'undefined'
        ? 1
        : query.page;

      $scope.users = [];

      function _refresh() {
        reloadUserList(false);
      }

      $timeout(reloadUserList);

      $scope.toggleActivated = function (user) {
        $timeout(function () {
          if (user.activated === 1) {
            user.$activate(_refresh, _refresh);
          } else {
            user.$deactivate(_refresh, _refresh);
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

      $scope.role = typeof query.role === 'undefined'
        ? 'all'
        : query.role;

      $scope.setRole = function (role) {
        $scope.role = role;

        $location.search('role', role);

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

      $scope.addUser = function () {
        location.href = '/account/edit';
      };

      $scope.edit = function (user) {
        location.href = '/account/edit#?id='+user.id;
      };

      $scope.remove = function (user, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this account?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          user.$remove(function () {
            toast($mdToast, 'success', {
              message: 'Account successfully removed'
            });

            _refresh();
          }, function () {
            toast($mdToast, 'error', {
              message: 'Error removing account'
            });
          });
        });
      };

      $scope.restore = function (user) {
        user.$restore(function () {
          toast($mdToast, 'success', {
            message: 'Account successfully restored'
          });

          _refresh();
        }, function () {
          toast($mdToast, 'error', {
            message: 'Error restoring account'
          });
        });
      };

      function reloadUserList(setTimeout) {
        if ($scope.searchFocus === true) {
          $timeout(reloadUserList, refreshInterval);

          return;
        }

        setTimeout = typeof setTimeout === 'boolean'
          ? setTimeout
          : true;

        User.query({
          deactivated: $scope.deactivated,
          deleted: $scope.deleted,
          role: $scope.role,
          search: $scope.search,
          sort: $scope.sort,
          page: loaded ? $scope.pagination.currentPage : page
        }, function (users, headers) {
          var _headers = headers();

          $scope.pagination = {
            totalCount: _headers['x-pagination-total-count'],
            pageCount: _headers['x-pagination-page-count'],
            currentPage: _headers['x-pagination-current-page'],
            perPage: _headers['x-pagination-per-page']
          };

          $scope.users = users;

          if (setTimeout) {
            $timeout(reloadUserList, refreshInterval);
          }

          loaded = true;
        });
      }
    }
  ]);