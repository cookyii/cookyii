angular.module('directives', [])

  .directive('ngIcheck', ['$timeout', iCheck])
  .directive('ngDatePicker', ['$timeout', DatePicker])
  .directive('ngDatetimePicker', ['$timeout', DatetimePicker])
  .directive('ngScrollPane', ['$window', '$timeout', ScrollPane]);

function iCheck($timeout) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function ($scope, element, $attrs, ngModel) {
      return $timeout(function () {
        var value = $attrs['value'];

        $scope.$watch($attrs['ngModel'], function (newValue) {
          jQuery(element).iCheck('update');
        });

        return jQuery(element).iCheck({
          checkboxClass: 'icheckbox_flat-red',
          radioClass: 'iradio_flat-red'
        }).on('ifChanged', function (event) {
          if (jQuery(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
            $scope.$apply(function () {
              return ngModel.$setViewValue(event.target.checked);
            });
          }
          if (jQuery(element).attr('type') === 'radio' && $attrs['ngModel']) {
            return $scope.$apply(function () {
              return ngModel.$setViewValue(value);
            });
          }
        });
      });
    }
  };
}

function DatePicker($timeout) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function ($scope, element, $attrs, ngModel) {
      return $timeout(function () {
        var options = {
          weekStart: 1,
          minView: 'month',
          language: 'ru',
          autoclose: true,
          format: 'dd.mm.yyyy',
          keyboardNavigation: false
        };

        if ($attrs['ngDatepicker']) {
          options = angular.merge(options, $scope.$eval($attrs['ngDatepicker']));
        }

        function eval(type) {
          if (typeof $attrs[type] !== 'undefined') {
            $scope.$apply(function () {
              $scope.$eval($attrs[type]);
            });
          }
        }

        return jQuery(element)
          .datetimepicker(options)
          .on('changeDate', function (e) {
            eval('ngDatepickerChange');
          })
          .on('hide', function (e) {
            eval('ngDatepickerHide');
          });
      });
    }
  };
}

function DatetimePicker($timeout) {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function ($scope, element, $attrs, ngModel) {
      return $timeout(function () {
        var options = {
          weekStart: 1,
          minView: 'hour',
          language: 'ru',
          autoclose: true,
          format: 'dd.mm.yyyy hh:ii',
          keyboardNavigation: false
        };

        if ($attrs['ngDatetimepicker']) {
          options = angular.merge(options, $scope.$eval($attrs['ngDatetimepicker']));
        }

        function eval(type) {
          if (typeof $attrs[type] !== 'undefined') {
            $scope.$apply(function () {
              $scope.$eval($attrs[type]);
            });
          }
        }

        return jQuery(element)
          .datetimepicker(options)
          .on('changeDate', function (e) {
            eval('ngDatetimepickerChange');
          })
          .on('hide', function (e) {
            eval('ngDatetimepickerHide');
          });
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
      var config = {
        mouseWheelSpeed: 80,
        horizontalGutter: 0,
        verticalGutter: 0
      };

      var $$window = angular.element($window);

      if (typeof $attrs.id === 'undefined') {
        $attrs.id = 'scroll-pane-' + parseInt(Math.random() * 10000000);
        $attrs.$$element.attr('id', $attrs.id);
      }

      if (typeof $attrs.ngScrollPane !== 'undefined') {
        config = angular.extend({}, config, $scope.$eval($attrs.ngScrollPane));
      }

      var fn = function () {
        var $pane = jQuery('#' + $attrs.id);

        if ($attrs.scrollFitToWindow) {
          var offset = parseInt($scope.$eval($attrs.scrollFitToWindow));
          offset = isNaN(offset) ? 0 : offset;
          $pane.height(angular.element($window).height() + offset);
        }

        $pane.jScrollPane(config);

        $scope.pane = $pane.data('jsp');

        $$window.trigger('resize');
      };

      if (typeof $attrs.scrollTimeout === 'string') {
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

      $$window.on('resize', function () {
        if ($scope.pane) {
          var $pane = angular.element('#' + $attrs.id),
            $content = $pane.find('.jspPane'),
            content_height = $content.height(),
            window_height = $$window.height() - angular.element('.main-header').height();

          if (content_height > window_height) {
            $pane.height(window_height);
          } else {
            $pane.height(content_height);
          }

          $scope.pane.reinitialise();
        }
      });

      return $scope;
    }
  };
}