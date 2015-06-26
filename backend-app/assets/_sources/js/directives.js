angular.module('directives', [])

  .directive('ngDatePicker', DatePicker)
  .directive('ngDatetimePicker', DatetimePicker);

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