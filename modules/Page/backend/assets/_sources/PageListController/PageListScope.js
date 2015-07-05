"use strict";

angular.module('BackendApp')

  .factory('PageListScope', [
    '$rootScope', '$timeout', '$mdDialog', 'QueryScope', 'FilterScope', 'ToastScope', 'PageResource',
    function ($rootScope, $timeout, $mdDialog, QueryScope, FilterScope, ToastScope, Page) {
      var $scope = $rootScope.$new(),
        page = QueryScope.get('page', 1),
        loaded = false;

      $scope.list = [];

      $scope.sort = QueryScope.get('sort', '-id');

      $scope.setSort = function (sort) {
        if ($scope.sort === sort) {
          $scope.sort = '-' + sort;
        } else {
          $scope.sort = sort;
        }

        QueryScope.set('sort', $scope.sort);

        _refresh();
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

      $scope.toggleActivated = function (page) {
        $timeout(function () {
          if (page.activated === 1) {
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
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this page?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          page.$remove(function () {
            ToastScope.send('success', {
              message: 'Page successfully removed'
            });

            _refresh();
          }, function () {
            ToastScope.send('error', {
              message: 'Error removing page'
            });
          });
        });
      };

      $scope.restore = function (page) {
        page.$restore(function () {
          ToastScope.send('success', {
            message: 'Page successfully restored'
          });

          _refresh();
        }, function () {
          ToastScope.send('error', {
            message: 'Error restoring page'
          });
        });
      };

      var reloadTimeout;

      $scope.reload = function () {
        Page.query({
          deactivated: FilterScope.deactivated,
          deleted: FilterScope.deleted,
          search: FilterScope.search.query,
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

          $scope.list = response;

          $timeout.cancel(reloadTimeout);
          reloadTimeout = $timeout($scope.reload, 5000);

          loaded = true;
        });
      };

      function _refresh() {
        $rootScope.$broadcast('refresh');
      }

      return $scope;
    }
  ]);