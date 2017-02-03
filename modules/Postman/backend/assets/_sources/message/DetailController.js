"use strict";

angular.module('BackendApp')

  .controller('postman.message.DetailController', [
    '$scope', '$timeout', 'QueryScope', 'postman.MessageResource',
    function ($scope, $timeout, QueryScope, Message) {

      var hash = null,
        query = QueryScope($scope),
        defaultValues = {
          subject: null,
          content_text: null,
          content_html: null,
          address: []
        };

      $scope.getMessageId = function () {
        return query.get('id');
      };

      $scope.isNewMessage = $scope.getMessageId() === null;

      $scope.$on('reloadMessageData', function (e) {
        $scope.reload();
      });

      $scope.reload = function (MessageEditForm) {
        $scope.isNewMessage = $scope.getMessageId() === null;

        $scope.messageUpdatedWarning = false;
        $scope.editedProperty = null;

        if ($scope.getMessageId() === null) {
          $scope.data = angular.copy(defaultValues);
        } else {
          Message.detail({id: $scope.getMessageId()}, function (message) {
            $scope.data = message;
            hash = message.hash;

            $scope.$broadcast('messageDataReloaded', message);
          });
        }

        if (typeof MessageEditForm === 'object') {
          MessageEditForm.$setPristine();
        }
      };

      $timeout($scope.reload);
      $timeout(checkMessageUpdate, 5000);

      $scope.messageUpdatedWarning = false;

      function checkMessageUpdate() {
        if ($scope.getMessageId() !== null) {
          Message.detail({id: $scope.getMessageId()}, function (message) {
            if (hash !== message.hash) {
              $scope.messageUpdatedWarning = true;
            }
          });

          $timeout(checkMessageUpdate, 5000);
        }
      }
    }
  ]);