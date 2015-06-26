"use strict";

angular.module('BackendApp')

  .controller('PageListController', [
    '$scope', '$http', '$timeout', '$mdToast', '$mdDialog', '$location', 'PageResource',
    function ($scope, $http, $timeout, $mdToast, $mdDialog, $location, Page) {
      var query = $location.search(),
        loaded = false,
        refreshInterval = 5000;

      var page = typeof query.page === 'undefined'
        ? 1
        : query.page;

      $scope.pages = [];

      function _refresh() {
        reloadPageList(false);
      }

      $timeout(reloadPageList);

      $scope.toggleActivated = function (page) {
        $timeout(function () {
          if (page.activated === 1) {
            page.$activate(_refresh, _refresh);
          } else {
            page.$deactivate(_refresh, _refresh);
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

      $scope.addPage = function () {
        location.href = '/page/edit';
      };

      $scope.edit = function (page) {
        location.href = '/page/edit#?id=' + page.id;
      };

      $scope.remove = function (page, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this page?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          page.$remove(function () {
            toast($mdToast, 'success', {
              message: 'Page successfully removed'
            });

            _refresh();
          }, function () {
            toast($mdToast, 'error', {
              message: 'Error removing page'
            });
          });
        });
      };

      $scope.restore = function (page) {
        page.$restore(function () {
          toast($mdToast, 'success', {
            message: 'Page successfully restored'
          });

          _refresh();
        }, function () {
          toast($mdToast, 'error', {
            message: 'Error restoring page'
          });
        });
      };

      function reloadPageList(setTimeout) {
        if ($scope.searchFocus === true) {
          $timeout(reloadPageList, refreshInterval);

          return;
        }

        setTimeout = typeof setTimeout === 'boolean'
          ? setTimeout
          : true;

        Page.query({
          deactivated: $scope.deactivated,
          deleted: $scope.deleted,
          search: $scope.search,
          sort: $scope.sort,
          page: loaded ? $scope.pagination.currentPage : page
        }, function (response, headers) {
          var _headers = headers();

          $scope.pagination = {
            totalCount: _headers['x-pagination-total-count'],
            pageCount: _headers['x-pagination-page-count'],
            currentPage: _headers['x-pagination-current-page'],
            perPage: _headers['x-pagination-per-page']
          };

          $scope.pages = response;

          if (setTimeout) {
            $timeout(reloadPageList, refreshInterval);
          }

          loaded = true;
        });
      }
    }
  ]);