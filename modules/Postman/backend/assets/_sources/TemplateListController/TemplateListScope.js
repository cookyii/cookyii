"use strict";

angular.module('BackendApp')

  .factory('TemplateListScope', [
    '$timeout', '$mdDialog', 'QueryScope', 'ToastrScope', 'SortScope', 'FilterScope', 'TemplateResource',
    function ($timeout, $mdDialog, QueryScope, ToastrScope, SortScope, FilterScope, Template) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          toastr = ToastrScope($scope),
          page = QueryScope.get('page', 1),
          loaded = false;

        $scope.sort = SortScope($scope);
        $scope.filter = FilterScope($scope);

        $scope.list = [];

        $scope.pagination = {
          currentPage: page
        };

        $scope.doPageChanged = function () {
          if (loaded === true) {
            QueryScope.set('page', $scope.pagination.currentPage);
          }

          _refresh();
        };

        $scope.toggleActivated = function (template) {
          $timeout(function () {
            if (template.activated === true) {
              template.$activate(_refresh, _refresh);
            } else {
              template.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
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
              toastr.success('Template successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing template');
            });
          });
        };

        $scope.restore = function (template) {
          template.$restore(function () {
            toastr.success('Template successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring template');
          });
        };

        var reloadTimeout;

        $scope.reload = function () {
          Template.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page
          }, function (templates, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = templates;

            $timeout.cancel(reloadTimeout);
            reloadTimeout = $timeout($scope.reload, 5000);

            loaded = true;
          });
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);