"use strict";

angular.module('BackendApp')

  .factory('ItemScope', [
    '$rootScope', '$timeout', '$mdDialog', 'QueryScope', 'SectionScope', 'FilterScope', 'ItemResource',
    function ($rootScope, $timeout, $mdDialog, QueryScope, SectionScope, FilterScope, Item) {
      var $scope = $rootScope.$new(),
        page = QueryScope.get('page', 1),
        loaded = false;

      $scope.lsit = [];

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

      $scope.toggleActivation = function (page) {
        $timeout(function () {
          if (page.activated === 1) {
            page.$activate(_refresh, _refresh);
          } else {
            page.$deactivate(_refresh, _refresh);
          }
        }, 400);
      };

      $scope.add = function () {
        var section = SectionScope.getSelected(),
          section_id = section === null ? null : section.id;

        location.href = '/feed/item/edit#?section=' + section_id;
      };

      $scope.edit = function (item) {
        location.href = '/feed/item/edit#?id=' + item.id;
      };

      $scope.remove = function (item, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this item?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          item.$remove(function () {
            ToastScope.send('success', {
              message: 'Item successfully removed'
            });

            _refresh();
          }, function () {
            ToastScope.send('error', {
              message: 'Error removing item'
            });
          });
        });
      };

      $scope.restore = function (item) {
        item.$restore(function () {
          ToastScope.send('success', {
            message: 'Item successfully restored'
          });

          _refresh();
        }, function () {
          ToastScope.send('error', {
            message: 'Error restoring item'
          });
        });
      };

      var reloadTimeout;

      $scope.reload = function () {
        if (SectionScope.selected === null) {
          $scope.items = [];

          return;
        }

        Item.query({
          deactivated: $scope.deactivated,
          deleted: FilterScope.deleted,
          search: FilterScope.search.query,
          section: SectionScope.selected,
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