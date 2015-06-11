"use strict";

angular.module('BackendApp')

  .controller('UserListController', [
    '$rootScope', '$scope', '$element', '$http', '$timeout', '$mdToast', '$location', 'UserRes',
    function ($rootScope, $scope, $element, $http, $timeout, $mdToast, $location, UserRes) {
      var loaded = false,
        query = $location.search(),
        page = typeof query.page === 'undefined' ? 1 : query.page;

      $scope.users = [];

      $scope.searchFocus = false;
      $scope.search = typeof query.search === 'undefined'
        ? null
        : query.search;

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

      $scope.addUser = function (e) {
        $rootScope.edit_account_id = null;
        jQuery('#AccountEditFormModal')
          .modal('show');

        e.preventDefault();
      };

      $scope.edit = function (user_id, e) {
        $rootScope.edit_account_id = user_id;
        jQuery('#AccountEditFormModal')
          .modal('show');

        e.preventDefault();
      };

      $scope.delete = function (user_id, e) {
        $http({
          method: 'DELETE',
          url: _config.url.delete,
          params: {user: user_id}
        }).success(function (response) {
          if (true === response.result) {
            toast($mdToast, 'success', {
              message: response.message
            });
          } else {
            toast($mdToast, 'error', {
              message: response.message
            });
          }

          reloadUserList(false);
        }).error(defaultHttpErrorHandler);

        e.preventDefault();
      };

      $scope.restore = function (user_id, e) {
        $http({
          method: 'PUT',
          url: _config.url.restore,
          params: {user: user_id}
        }).success(function (response) {
          if (true === response.result) {
            toast($mdToast, 'success', {
              message: response.message
            });
          } else {
            toast($mdToast, 'error', {
              message: response.message
            });
          }

          reloadUserList(false);
        }).error(defaultHttpErrorHandler);

        e.preventDefault();
      };

      $rootScope.$on('ListRefresh', function () {
        reloadUserList(false);
      });

      $timeout(reloadUserList);

      function reloadUserList(setTimeout) {
        setTimeout = typeof setTimeout === 'boolean' ? setTimeout : true;

        UserRes.query({
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
            $timeout(reloadUserList, 5000);
          }

          loaded = true;
        });
      }
    }
  ]);