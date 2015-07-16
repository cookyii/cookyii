"use strict";

angular.module('BackendApp')

  .controller('MessageEditController', [
    '$scope', '$http', '$location', '$timeout', 'ToastScope',
    function ($scope, $http, $location, $timeout, ToastScope) {
      var query = $location.search();

      $scope.inProgress = false;

      $scope.address_types = [
        {id: 1, label: 'Reply to'},
        {id: 2, label: 'To'},
        {id: 3, label: 'Cc'},
        {id: 4, label: 'Bcc'}
      ];

      var selectedTab = typeof query.tab === 'undefined'
        ? 'content'
        : query.tab;

      $scope.tabs = {
        content: selectedTab === 'content',
        address: selectedTab === 'address',
        preview: selectedTab === 'preview'
      };

      $scope.selectTab = function (tab) {
        $location.search('tab', tab);

        $timeout(function () {
          jQuery(window).trigger('resize');
        });
      };

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
          .success(function (response) {
            if (response.result === false) {
              MessageEditForm.$setDirty();

              if (typeof response.errors !== 'undefined') {
                angular.forEach(response.errors, function (message, field) {
                  $scope.error[field] = message;
                });
              } else {
                ToastScope.send('error', {
                  message: 'Save error'
                });
              }
            } else {
              ToastScope.send('success', {
                message: 'Message successfully saved'
              });

              if ($scope.$parent.isNewMessage) {
                $location.search('id', response.message_id);
              }

              $scope.reload();
            }
          })
          .error(function (response) {
            MessageEditForm.$setDirty();

            if (typeof response.data !== 'undefined') {
              angular.forEach(response.data, function (val, index) {
                $scope.error[val.field] = val.message;
              });
            } else {
              ToastScope.send('error', {
                message: 'Error updating message'
              });
            }
          })
          .finally(function () {
            $scope.inProgress = false;
          });

        e.preventDefault();
      }
    }
  ]);