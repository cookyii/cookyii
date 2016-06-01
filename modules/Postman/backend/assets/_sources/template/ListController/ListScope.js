"use strict";

angular.module('BackendApp')

  .factory('postman.template.list.ListScope', [
    '$timeout', 'QueryScope', 'ToastrScope', 'SortScope', 'postman.template.list.FilterScope', 'postman.TemplateResource',
    function ($timeout, QueryScope, ToastrScope, SortScope, FilterScope, Template) {
      return function ($parentScope) {

        var $scope = $parentScope.$new(),
          query = QueryScope($scope),
          toastr = ToastrScope($scope),
          page = query.get('page', 1),
          loaded = false;

        $scope.sort = SortScope($scope);
        $scope.filter = FilterScope($scope);

        $scope.list = [];

        $scope.inProgress = false;

        $scope.pagination = {
          currentPage: page
        };

        $scope.doPageChanged = function () {
          if (loaded === true) {
            query.set('page', $scope.pagination.currentPage);
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
          swal({
            type: "warning",
            title: "Would you like to delete this template?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
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

        $scope.reload = function () {
          $scope.inProgress = true;

          Template.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page,
            expand: 'created_at,updated_at'
          }, function (templates, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = templates;

            loaded = true;

            $scope.inProgress = false;
          });
        };

        function _refresh() {
          $parentScope.$emit('refresh');
        }

        return $scope;
      }
    }
  ]);