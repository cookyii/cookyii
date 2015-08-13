"use strict";

angular.module('BackendApp')

  .factory('MessageListScope', [
    '$timeout', '$mdDialog', 'QueryScope', 'ToastScope', 'SortScope', 'FilterScope', 'MessageResource',
    function ($timeout, $mdDialog, QueryScope, ToastScope, SortScope, FilterScope, Message) {
      return function ($parentScope) {
        var $scope = $parentScope.$new(),
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
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to resent this message?')
            .ok('Please resent it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            message.$resent(function () {
              ToastScope.send('success', {
                message: 'Message successfully resent'
              });

              _refresh();
            }, function () {
              ToastScope.send('error', {
                message: 'Error resenting message'
              });
            });
          });

          e.stopPropagation();
        };

        $scope.remove = function (message, e) {
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to delete this message?')
            .ok('Please do it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            message.$remove(function () {
              ToastScope.send('success', {
                message: 'Message successfully removed'
              });

              _refresh();
            }, function () {
              ToastScope.send('error', {
                message: 'Error removing message'
              });
            });
          });
        };

        $scope.restore = function (message) {
          message.$restore(function () {
            ToastScope.send('success', {
              message: 'Message successfully restored'
            });

            _refresh();
          }, function () {
            ToastScope.send('error', {
              message: 'Error restoring message'
            });
          });
        };

        var reloadTimeout;

        $scope.reload = function () {
          Message.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page
          }, function (messages, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = messages;

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