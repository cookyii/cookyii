"use strict";

angular.module('BackendApp')

  .factory('ItemListScope', [
    '$rootScope', '$timeout', '$mdDialog', 'QueryScope', 'SectionListScope', 'FilterScope', 'ToastScope', 'ItemResource',
    function ($rootScope, $timeout, $mdDialog, QueryScope, SectionListScope, FilterScope, ToastScope, Item) {
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

      $scope.toggleActivation = function (item) {
        $timeout(function () {
          if (item.activated === 1) {
            item.$activate(_refresh, _refresh);
          } else {
            item.$deactivate(_refresh, _refresh);
          }
        }, 400);
      };

      $scope.add = function () {
        var section = SectionListScope.getSelected(),
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
        if (SectionListScope.selected === null) {
          $scope.list = [];

          return;
        }

        Item.query({
          deactivated: $scope.deactivated,
          deleted: FilterScope.deleted,
          search: FilterScope.search.query,
          section: SectionListScope.selected,
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