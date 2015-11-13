jQuery(function ($) {

  var $body = $('body'),
    $document = $(document),
    $window = $(window);

  $window.load(function () {
    $('#global-loader').hide();
    $('body').delay(350).css({'overflow': 'visible'});
  });

  $window.on('resize', function () {
    $('#page-wrapper').css('min-height', $window.height());
  });

  $window.trigger('resize');
});