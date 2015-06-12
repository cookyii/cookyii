"use strict";

angular.module('BackendApp')

  .controller('UserListController', [
    '$rootScope', '$scope', '$element', '$http', '$timeout', '$mdToast', '$location', 'UserResource',
    function ($rootScope, $scope, $element, $http, $timeout, $mdToast, $location, User) {
      var query = $location.search(),
        loaded = false,
        refreshInterval = 5000;

      var page = typeof query.page === 'undefined'
        ? 1
        : query.page;

      $scope.users = [];

      $scope.deleted = typeof query.deleted === 'undefined'
        ? false
        : query.deleted === 'true';

      $scope.toggleDeleted = function () {
        $scope.deleted = !$scope.deleted;

        console.log($scope.deleted);

        $location.search('deleted', $scope.deleted === true ? 'true' : 'false');

        reloadUserList(false);
      };

      $scope.role = typeof query.role === 'undefined'
        ? 'all'
        : query.role;

      $scope.setRole = function (role) {
        $scope.role = role;

        $location.search('role', role);

        reloadUserList(false);
      };

      $scope.searchFocus = false;
      $scope.search = typeof query.search === 'undefined'
        ? null
        : query.search;

      $rootScope.$on('ListRefresh', function () {
        reloadUserList(false);
      });

      $scope.doSearch = function () {
        $location.search('search', $scope.search);

        reloadUserList(false);
      };

      $scope.toggleSearchFocus = function () {
        $scope.searchFocus = !$scope.searchFocus;
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

        reloadUserList(false);
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

        reloadUserList(false);
      };

      $scope.addUser = function () {
        $rootScope.$emit('editAccount', null);
        jQuery('#AccountEditFormModal')
          .modal('show');
      };

      $scope.edit = function (user) {
        $rootScope.$emit('editAccount', angular.copy(user));
        jQuery('#AccountEditFormModal')
          .modal('show');
      };

      $scope.toggleActivated = function (user) {
        if (user.activated === 1) {
          user.$deactivate();
        } else {
          user.$activate();
        }

        reloadUserList(false);
      };

      $scope.remove = function (user) {
        user.$remove(function () {
          toast($mdToast, 'success', {
            message: 'Account successfully removed'
          });

          reloadUserList(false);
        }, function () {
          toast($mdToast, 'error', {
            message: 'Error removing account'
          });
        });
      };

      $scope.restore = function (user) {
        user.$restore(function () {
          toast($mdToast, 'success', {
            message: 'Account successfully restored'
          });

          reloadUserList(false);
        }, function () {
          toast($mdToast, 'error', {
            message: 'Error restoring account'
          });
        });
      };

      $timeout(reloadUserList);

      function reloadUserList(setTimeout) {
        setTimeout = typeof setTimeout === 'boolean'
          ? setTimeout
          : true;

        User.query({
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