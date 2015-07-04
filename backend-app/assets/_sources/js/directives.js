angular.module('directives', [])

  .directive('ngDatePicker', DatePicker)
  .directive('ngDatetimePicker', DatetimePicker)
  .directive('ngScrollPane', ['$window', '$timeout', ScrollPane]);

function DatePicker() {
  return {
    restrict: 'A',
    require: 'ngModel',
    scope: {
      dateStart: '=ngDateStart'
    },
    link: function (scope, element, attrs, ngModelCtrl) {
      element.datetimepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
        weekStart: 1,
        minView: 'month'
      });

      scope.$watch('dateStart', function (val) {
        element.datetimepicker(
          'setStartDate',
          typeof val === 'undefined'
            ? null
            : val.substr(0, 10)
        );
      });
    }
  };
}

function DatetimePicker() {
  return {
    restrict: 'A',
    require: 'ngModel',
    scope: {
      dateStart: '=ngDateStart'
    },
    link: function (scope, element, attrs, ngModelCtrl) {
      element.datetimepicker({
        format: 'dd.mm.yyyy hh:ii',
        autoclose: true,
        weekStart: 1
      });

      scope.$watch('dateStart', function (val) {
        element.datetimepicker(
          'setStartDate',
          typeof val === 'undefined'
            ? null
            : val.substr(0, 10)
        );
      });
    }
  };
}

function ScrollPane($window, $timeout) {
  return {
    restrict: 'A',
    transclude: true,
    replace: true,
    template: '<div class="scroll-pane"><div ng-transclude></div></div>',
    link: function ($scope, $elem, $attrs) {
      var config = {};

      if (typeof $attrs.id === 'undefined') {
        $attrs.id = 'scroll-pane-' + (Math.random() * 100000);
        $attrs.$$element.attr('id', $attrs.id);
      }

      if (typeof $attrs.scrollConfig !== 'undefined') {
        config = $scope.$eval($attrs.scrollConfig);
      }

      var fn = function () {
        var $pane = jQuery('#' + $attrs.id);

        if ($attrs.scrollFitToWindow) {
          var offset = parseInt($scope.$eval($attrs.scrollFitToWindow));
          offset = isNaN(offset) ? 0 : offset;
          $pane.height(angular.element($window).height() + offset);
        }

        $pane.jScrollPane(config);

        return $scope.pane = $pane.data('jsp');
      };

      if ($attrs.scrollTimeout) {
        $timeout(fn, $scope.$eval($attrs.scrollTimeout));
      } else {
        fn();
      }

      $scope.$on('scrollpane-scroll-to', function (event, id, selector) {
        if (id === $attrs.id && $scope.pane) {
          $scope.pane.scrollToElement(jQuery('#' + id + ' ' + selector), false, true);
        }
      });

      $scope.$on('scrollpane-reinit', function (event, id) {
        if (id === $attrs.id && $scope.pane) {
          return $scope.$apply(function () {
            $scope.pane.reinitialise();

            return fn();
          });
        }
      });

      $scope.$on('scrollpane-reinit-all', function (event) {
        if ($scope.pane) {
          $timeout(function () {
            $scope.pane.reinitialise();

            return fn();
          });
        }
      });

      return $scope;
    }
  };
}