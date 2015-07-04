"use strict";

angular.module('BackendApp')

  .controller('TemplateListController', [
    '$scope', '$http', '$timeout', 'ToastScope', '$mdDialog', '$location', 'TemplateResource',
    function ($scope, $http, $timeout, ToastScope, $mdDialog, $location, Template) {
      var query = $location.search(),
        loaded = false,
        refreshInterval = 5000;

      var page = typeof query.page === 'undefined'
        ? 1
        : query.page;

      $scope.templates = [];

      function _refresh() {
        reloadTemplateList(false);
      }

      $timeout(reloadTemplateList);

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

      $scope.addTemplate = function () {
        location.href = '/postman/template/edit';
      };

      $scope.edit = function (template) {
        location.href = '/postman/template/edit#?id=' + template.id;
      };

      $scope.remove = function (template, e) {
        var confirm = $mdDialog.confirm()
          .parent(angular.element(document.body))
          .title('Would you like to delete this template?')
          .ok('Please do it!')
          .cancel('Cancel')
          .targetEvent(e);

        $mdDialog.show(confirm).then(function () {
          template.$remove(function () {
            ToastScope.send('success', {
              message: 'Template successfully removed'
            });

            _refresh();
          }, function () {
            ToastScope.send('error', {
              message: 'Error removing template'
            });
          });
        });
      };

      $scope.restore = function (template) {
        template.$restore(function () {
          ToastScope.send('success', {
            message: 'Template successfully restored'
          });

          _refresh();
        }, function () {
          ToastScope.send('error', {
            message: 'Error restoring template'
          });
        });
      };

      function reloadTemplateList(setTimeout) {
        if ($scope.searchFocus === true) {
          $timeout(reloadTemplateList, refreshInterval);

          return;
        }

        setTimeout = typeof setTimeout === 'boolean'
          ? setTimeout
          : true;

        Template.query({
          deactivated: $scope.deactivated,
          deleted: $scope.deleted,
          search: $scope.search,
          sort: $scope.sort,
          page: loaded ? $scope.pagination.currentPage : page
        }, function (templates, headers) {
          var _headers = headers();

          $scope.pagination = {
            totalCount: _headers['x-pagination-total-count'],
            pageCount: _headers['x-pagination-page-count'],
            currentPage: _headers['x-pagination-current-page'],
            perPage: _headers['x-pagination-per-page']
          };

          $scope.templates = templates;

          if (setTimeout) {
            $timeout(reloadTemplateList, refreshInterval);
          }

          loaded = true;
        });
      }
    }
  ]);