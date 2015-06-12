"use strict";

angular.module('BackendApp')

  .factory('UserResource', ['$resource',
    function ($resource) {
      return $resource('/account/rest/users/:method:user', {user: '@id', method: ''}, {
        'activate': {method: 'POST', params: {method: 'activate/'}},
        'deactivate': {method: 'POST', params: {method: 'deactivate/'}},
        'update': {method: 'PUT'},
        'restore': {method: 'PATCH'}
      });
    }]);