"use strict";

angular.module('BackendApp')

  .factory('UserRes', ['$resource',
    function ($resource) {
      return $resource('/account/rest/user/:userId', {userId: '@id'});
    }]);