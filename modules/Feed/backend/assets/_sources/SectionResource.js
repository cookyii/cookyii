"use strict";

angular.module('BackendApp')

  .factory('SectionResource', ['$resource',
    function ($resource) {
      return $resource('/feed/section/rest/sections/:action:id:slug', {
        action: '',
        id: '@id',
        slug: '@slug'
      }, {
        'tree': {method: 'GET', 'params': {action: 'tree'}},
        'detail': {method: 'GET', 'params': {action: 'detail/'}},
        'activate': {method: 'POST', params: {action: 'activate/'}},
        'deactivate': {method: 'POST', params: {action: 'deactivate/'}},
        'update': {method: 'PUT'},
        'restore': {method: 'PATCH'}
      });
    }]);