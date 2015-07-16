"use strict";

angular.module('BackendApp')

  .factory('MessageResource', ['$resource',
    function ($resource) {
      return $resource('/postman/rest/messages/:action:id', {
        action: '',
        id: '@id'
      }, {
        'detail': {method: 'GET', 'params': {action: 'detail/'}},
        'resent': {method: 'PUT', 'params': {action: 'resent/'}},
        'update': {method: 'PUT'},
        'restore': {method: 'PATCH'}
      });
    }]);