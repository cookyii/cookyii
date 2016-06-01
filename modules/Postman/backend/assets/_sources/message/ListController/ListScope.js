"use strict";

angular.module('BackendApp')

  .factory('postman.message.list.ListScope', [
    '$timeout', 'QueryScope', 'ToastrScope', 'SortScope', 'postman.message.list.FilterScope', 'postman.MessageResource',
    function ($timeout, QueryScope, ToastrScope, SortScope, FilterScope, Message) {
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

        $scope.toggleActivated = function (message) {
          $timeout(function () {
            if (message.activated === true) {
              message.$activate(_refresh, _refresh);
            } else {
              message.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
          location.href = '/postman/message/edit';
        };

        $scope.edit = function (message) {
          location.href = '/postman/message/edit#?id=' + message.id;
        };

        $scope.resent = function (message, e) {
          swal({
            type: "warning",
            title: "Would you like to resent this message?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
            message.$resent(function () {
              toastr.success('Message successfully resent');

              _refresh();
            }, function () {
              toastr.error('Error resenting message');
            });
          });

          e.stopPropagation();
        };

        $scope.remove = function (message, e) {
          swal({
            type: "warning",
            title: "Would you like to delete this message?",
            showCancelButton: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmButtonText: "Please do it!",
            cancelButtonText: "Cancel"
          }, function () {
            message.$remove(function () {
              toastr.success('Message successfully removed');

              _refresh();
            }, function () {
              toastr.error('Error removing message');
            });
          });
        };

        $scope.restore = function (message) {
          message.$restore(function () {
            toastr.success('Message successfully restored');

            _refresh();
          }, function () {
            toastr.error('Error restoring message');
          });
        };

        $scope.reload = function () {
          $scope.inProgress = true;

          Message.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page,
            expand: 'created_at,scheduled_at,sent_at'
          }, function (messages, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = messages;

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