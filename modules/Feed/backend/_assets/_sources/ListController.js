"use strict";

angular.module('BackendApp')

  .controller('ListController', [
    '$scope', '$http', '$timeout', '$mdToast', '$mdDialog', '$location', 'ItemResource', 'SectionResource',
    function ($scope, $http, $timeout, $mdToast, $mdDialog, $location, Item, Section) {
      var query = $location.search(),
        loaded = false,
        refreshInterval = 5000;

      var page = typeof query.page === 'undefined'
        ? 1
        : query.page;

      $scope.section = typeof query.section === 'undefined'
        ? null
        : query.section;

      $scope.sections = {};
      $scope.sections_tree = [];
      $scope.items = [];

      $scope.fab = {
        isOpen: false,
        selectedMode: 'md-fling',
        selectedDirection: 'up'
      };

      function _refresh() {
        reloadSectionList();
        reloadItemList();
      }

      $timeout(reloadSectionList);
      $timeout(reloadItemList);

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

      $scope.setSection = function (section) {
        if ($scope.section === section.slug) {
          $scope.section = null;
        } else {
          $scope.section = section.slug;
        }

        $location.search('section', $scope.section);

        _refresh();
      };

      $scope.isOpenedSection = function (section) {
        return section.contain.indexOf($scope.section) > -1;
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

      $scope.addSection = function () {
        location.href = '/feed/section/edit#?parent=' + $scope.sections[$scope.section].id;
      };

      $scope.editSection = function (section) {
        location.href = '/feed/section/edit#?section=' + section;
      };

      $scope.addItem = function () {
        location.href = '/feed/item/edit#?section=' + $scope.section;
      };

      $scope.editItem = function (item) {
        location.href = '/feed/item/edit#?id=' + item.id;
      };

      $scope.removeSection = function (section, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this section?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          Section.remove({slug: section}, function () {
            toast($mdToast, 'success', {
              message: 'Section successfully removed'
            });

            _refresh();
          }, function () {
            toast($mdToast, 'error', {
              message: 'Error removing section'
            });
          });
        });
      };

      $scope.restoreSection = function (section) {
        Section.restore({slug: section}, function () {
          toast($mdToast, 'success', {
            message: 'Section successfully restored'
          });

          _refresh();
        }, function () {
          toast($mdToast, 'error', {
            message: 'Error restoring section'
          });
        });
      };

      $scope.removeItem = function (item, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this item?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          item.$remove(function () {
            toast($mdToast, 'success', {
              message: 'Item successfully removed'
            });

            _refresh();
          }, function () {
            toast($mdToast, 'error', {
              message: 'Error removing item'
            });
          });
        });
      };

      $scope.restoreItem = function (item) {
        item.$restore(function () {
          toast($mdToast, 'success', {
            message: 'Item successfully restored'
          });

          _refresh();
        }, function () {
          toast($mdToast, 'error', {
            message: 'Error restoring item'
          });
        });
      };

      var reloadSectionListTimeout;

      function reloadSectionList() {
        if ($scope.searchFocus === true) {
          $timeout(reloadSectionList, refreshInterval);

          return;
        }

        Section.tree({
          deleted: $scope.deleted
        }, function (response) {
          $scope.sections_tree = response.sections;
          $scope.sections = response.models;

          $timeout.cancel(reloadSectionListTimeout);
          reloadSectionListTimeout = $timeout(reloadSectionList, refreshInterval);
        });
      }

      var reloadItemListTimeout;

      function reloadItemList() {
        if ($scope.section === null) {
          $scope.items = [];

          return;
        }

        if ($scope.searchFocus === true) {
          reloadItemListTimeout = $timeout(reloadItemList, refreshInterval);

          return;
        }

        Item.query({
          deactivated: $scope.deactivated,
          deleted: $scope.deleted,
          search: $scope.search,
          section: $scope.section,
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

          $scope.items = response;

          $timeout.cancel(reloadItemListTimeout);
          reloadItemListTimeout = $timeout(reloadItemList, refreshInterval);

          loaded = true;
        });
      }
    }
  ]);