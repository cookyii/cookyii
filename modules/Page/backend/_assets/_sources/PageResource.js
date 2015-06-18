"use strict";

angular.module('BackendApp')

  .factory('PageResource', ['$resource',
    function ($resource) {
      return $resource('/page/rest/pages/:action:id', {
        action: '',
        id: '@id'
      }, {
        'detail': {method: 'GET', 'params': {action: 'detail/'}},
        'activate': {method: 'POST', params: {action: 'activate/'}},
        'deactivate': {method: 'POST', params: {action: 'deactivate/'}},
        'update': {method: 'PUT'},
        'restore': {method: 'PATCH'}
      });
    }]);