(function (ng) {

  ng.module('cookyii.directives', [])

    .constant('iCheckConfig', iCheckConfig())
    .constant('datetimePickerConfig', datetimePickerConfig())

    .directive('ngIcheck', ['$timeout', 'iCheckConfig', iCheck])
    .directive('ngCustomCheckbox', ['$timeout', '$compile', customCheckbox])
    .directive('ngCustomRadio', ['$timeout', '$compile', customRadio])
    .directive('ngDatePicker', ['$timeout', 'datetimePickerConfig', DatePicker])
    .directive('ngTimePicker', ['$timeout', 'datetimePickerConfig', TimePicker])
    .directive('ngDatetimePicker', ['$timeout', 'datetimePickerConfig', DatetimePicker])
    .directive('ngScrollPane', ['$window', '$timeout', ScrollPane]);

  function iCheckConfig() {
    return {
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red'
    };
  }

  function datetimePickerConfig() {
    return {
      weekStart: 1,
      language: 'en',
      autoclose: true
    };
  }

  function iCheck($timeout, iCheckConfig) {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function ($scope, element, $attrs, ngModel) {
        return $timeout(function () {

          var value = $attrs['value'],
            options = {};

          $scope.$watch($attrs['ngModel'], function (newValue) {
            jQuery(element).iCheck('update');
          });

          try {
            options = typeof $attrs['ngIcheck'] === 'string' && $attrs['ngIcheck'].length > 0
              ? $scope.$eval($attrs['ngIcheck'])
              : {};
          } catch (e) {
            options = {};
          }

          options = ng.merge(iCheckConfig, options);

          return jQuery(element).iCheck(options)
            .on('ifChanged', function (event) {
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

  function customCheckbox($timeout, $compile) {
    return {
      restrict: 'A',
      scope: {
        ngModel: '='
      },
      link: function ($scope, $element, attrs) {
        return $timeout(function () {

          $scope.checked = $scope.ngModel;

          $scope.$watch('ngModel', function (val) {
            $scope.checked = val;
          });

          $scope.setValue = function () {
            $scope.ngModel = !$element.prop('checked');
          };

          $element.on('change', function () {
            $scope.$apply(function () {
              $scope.ngModel = $element.prop('checked');
            });
          });

          $element.css({
            position: 'absolute',
            left: '-1000px'
          });

          $element.after($compile('<i class="custom-checkbox fa fa-fw" ng-class="{\'fa-square\':!checked,\'fa-check-square\':checked}"></i>')($scope));
        });
      }
    };
  }

  function customRadio($timeout, $compile) {
    return {
      restrict: 'A',
      scope: {
        ngModel: '='
      },
      link: function ($scope, $element, attrs) {
        return $timeout(function () {

          $scope.checked = ($scope.ngModel + '') === $element.val();

          $scope.$watch('ngModel', function (val) {
            $scope.checked = (val + '') === $element.val();
          });

          $scope.setValue = function () {
            $scope.ngModel = $element.val();
          };

          $element.on('change', function () {
            $scope.$apply(function () {
              $scope.ngModel = $element.val();
            });
          });

          $element.css({
            position: 'absolute',
            left: '-1000px'
          });

          $element.after($compile('<i class="custom-radio fa fa-fw" ng-class="{\'fa-circle-o\':!checked,\'fa-dot-circle-o\':checked}"></i>')($scope));
        });
      }
    };
  }

  function DatePicker($timeout, datetimePickerConfig) {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function ($scope, element, $attrs, ngModel) {
        return $timeout(function () {
          var options = ng.merge(datetimePickerConfig, {
            minView: 'month',
            format: 'dd.mm.yyyy'
          });

          if ($attrs['ngDatePicker']) {
            options = ng.merge(options, $scope.$eval($attrs['ngDatePicker']));
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
              eval('ngDatePickerChange');
            })
            .on('hide', function (e) {
              eval('ngDatePickerHide');
            });
        });
      }
    };
  }

  function TimePicker($timeout, datetimePickerConfig) {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function ($scope, element, $attrs, ngModel) {
        return $timeout(function () {
          var options = ng.merge(datetimePickerConfig, {
            startView: 'day',
            minView: 'hour',
            format: 'hh:ii'
          });

          if ($attrs['ngTimePicker']) {
            options = ng.merge(options, $scope.$eval($attrs['ngTimePicker']));
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
              eval('ngTimePickerChange');
            })
            .on('hide', function (e) {
              eval('ngTimePickerHide');
            });
        });
      }
    };
  }

  function DatetimePicker($timeout, datetimePickerConfig) {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function ($scope, element, $attrs, ngModel) {
        return $timeout(function () {
          var options = ng.merge(datetimePickerConfig, {
            minView: 'hour',
            format: 'dd.mm.yyyy hh:ii'
          });

          if ($attrs['ngDatetimePicker']) {
            options = ng.merge(options, $scope.$eval($attrs['ngDatetimePicker']));
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
              eval('ngDatetimePickerChange');
            })
            .on('hide', function (e) {
              eval('ngDatetimePickerHide');
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

        var $$window = ng.element($window);

        if (typeof $attrs.id === 'undefined') {
          $attrs.id = 'scroll-pane-' + parseInt(Math.random() * 10000000);
          $attrs.$$element.attr('id', $attrs.id);
        }

        if (typeof $attrs.ngScrollPane !== 'undefined') {
          config = ng.extend({}, config, $scope.$eval($attrs.ngScrollPane));
        }

        var fn = function () {
          var $pane = jQuery('#' + $attrs.id);

          if ($attrs.scrollFitToWindow) {
            var offset = parseInt($scope.$eval($attrs.scrollFitToWindow));
            offset = isNaN(offset) ? 0 : offset;
            $pane.height(ng.element($window).height() + offset);
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
            var $pane = ng.element('#' + $attrs.id),
              $content = $pane.find('.jspPane'),
              content_height = $content.height(),
              window_height = $$window.height() - ng.element('.main-header').height();

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
}(angular));
