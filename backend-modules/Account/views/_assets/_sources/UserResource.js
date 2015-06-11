"use strict";

angular.module('BackendApp')

  .factory('UserResource', ['$resource',
    function ($resource) {
      return $resource('/account/rest/users/:user', {user: '@id'}, {
        'update': {method: 'PUT'},
        'restore': {method: 'PATCH'}
      });
    }]);