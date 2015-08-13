"use strict";

angular.module('CrmApp')

  .factory('ClientResource', ['$resource',
    function ($resource) {
      return $resource('/client/rest/clients/:action:id', {
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