"use strict";

angular.module('CrmApp')

  .factory('ClientListScope', [
    '$timeout', '$mdDialog', 'QueryScope', 'ToastScope', 'SortScope', 'FilterScope', 'ClientResource',
    function ($timeout, $mdDialog, QueryScope, ToastScope, SortScope, FilterScope, Client) {
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

        $scope.toggleActivated = function (client) {
          $timeout(function () {
            if (client.activated === true) {
              client.$activate(_refresh, _refresh);
            } else {
              client.$deactivate(_refresh, _refresh);
            }
          }, 400);
        };

        $scope.add = function () {
          location.href = '/client/edit';
        };

        $scope.edit = function (client) {
          location.href = '/client/edit#?id=' + client.id;
        };

        $scope.remove = function (client, e) {
          var confirm = $mdDialog.confirm()
            .parent(angular.element(document.body))
            .title('Would you like to delete this client?')
            .ok('Please do it!')
            .cancel('Cancel')
            .targetEvent(e);

          $mdDialog.show(confirm).then(function () {
            client.$remove(function () {
              ToastScope.send('success', {
                message: 'Client successfully removed'
              });

              _refresh();
            }, function () {
              ToastScope.send('error', {
                message: 'Error removing client'
              });
            });
          });
        };

        $scope.restore = function (client) {
          client.$restore(function () {
            ToastScope.send('success', {
              message: 'Client successfully restored'
            });

            _refresh();
          }, function () {
            ToastScope.send('error', {
              message: 'Error restoring client'
            });
          });
        };

        var reloadTimeout;

        $scope.reload = function () {
          Client.query({
            deactivated: $scope.filter.deactivated,
            deleted: $scope.filter.deleted,
            search: $scope.filter.search.query,
            sort: $scope.sort.order,
            page: loaded ? $scope.pagination.currentPage : page
          }, function (clients, headers) {
            var _headers = headers();

            $scope.pagination = {
              totalCount: _headers['x-pagination-total-count'],
              pageCount: _headers['x-pagination-page-count'],
              currentPage: _headers['x-pagination-current-page'],
              perPage: _headers['x-pagination-per-page']
            };

            $scope.list = clients;

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