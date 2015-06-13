"use strict";

angular.module('BackendApp')

  .factory('UserResource', ['$resource',
    function ($resource) {
      return $resource('/account/rest/users/:method:user', {user: '@id', method: ''}, {
        'detail': {method: 'GET', 'params': {method: 'detail/'}},
        'activate': {method: 'POST', params: {method: 'activate/'}},
        'deactivate': {method: 'POST', params: {method: 'deactivate/'}},
        'update': {method: 'PUT'},
        'restore': {method: 'PATCH'}
      });
    }]);