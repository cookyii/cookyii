"use strict";

angular.module('BackendApp')

  .factory('UdpWebSocket', [
    '$location', '$timeout', '$websocket',
    function ($location, $timeout, $websocket) {
      var dataStream = $websocket('ws://' + $location.$$host + ':18665/udp'),
        handlers = [];

      dataStream.onMessage(function (message) {
        angular.forEach(handlers, function (handler) {
          if (message.data.match(handler.mask) && typeof handler.function === 'function') {
            handler.function();
          }
        });
      });

      return {
        stream: dataStream,
        on: function (regexp, callback) {
          handlers.push({
            'mask': regexp,
            'function': callback
          });
        },
        send: function (data) {
          $timeout(function () {
            dataStream.send(JSON.stringify(data));
          }, 100);
        }
      };
    }]);