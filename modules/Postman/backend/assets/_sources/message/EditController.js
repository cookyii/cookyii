"use strict";

angular.module('BackendApp')

  .controller('postman.message.EditController', [
    '$scope', '$http', '$timeout', 'QueryScope', 'TabScope', 'ToastrScope',
    function ($scope, $http, $timeout, QueryScope, TabScope, ToastrScope) {

      var query = QueryScope($scope),
        toastr = ToastrScope($scope);

      $scope.inProgress = false;

      $scope.address_types = [
        {id: 1, label: 'Reply to'},
        {id: 2, label: 'To'},
        {id: 3, label: 'Cc'},
        {id: 4, label: 'Bcc'}
      ];

      $scope.tab = TabScope($scope);

      $scope.addAddress = function () {
        $scope.$parent.data.address.push({
          type: 2,
          email: null,
          name: null
        });
      };

      $scope.removeAddress = function (index) {
        delete $scope.$parent.data.address[index];
      };

      $scope.previewUrl = function (message, type) {
        if (typeof message === 'undefined') {
          return false;
        }

        return '/postman/message/preview?'
          + 'type=' + encodeURIComponent(type)
          + '&subject=' + encodeURIComponent(message.subject)
          + '&content=' + encodeURIComponent(type === 'html' ? message.content_html : message.content_text)
          + '&use_layout=' + encodeURIComponent($scope.$parent.isNewMessage ? 'true' : 'false');
      };

      $scope.submit = function (MessageEditForm, e) {
        var $form = angular.element('#MessageEditForm');

        MessageEditForm.$setPristine();

        $scope.error = {};
        $scope.inProgress = true;
        $http({
          method: 'POST',
          url: $form.attr('action'),
          data: {
            _csrf: $form.find('input[name="_csrf"]').val(),
            message_id: $scope.$parent.getMessageId(),
            MessageEditForm: $scope.data
          }
        })
          .then(function (response) {
            if (response.data.result === false) {
              MessageEditForm.$setDirty();

              if (typeof response.data.errors !== 'undefined') {
                angular.forEach(response.data.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                toastr.error('Save error');
              }
            } else {
              toastr.success('Message successfully saved');

              if ($scope.$parent.isNewMessage) {
                query.set('id', response.data.message_id);
              }

              $scope.reload();
            }
          }, function (response) {
            MessageEditForm.$setDirty();

            if (typeof response.data.data !== 'undefined') {
              angular.forEach(response.data.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              toastr.error('Error updating message');
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      }
    }
  ]);