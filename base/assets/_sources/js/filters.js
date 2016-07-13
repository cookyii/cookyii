(function (ng) {
  "use strict";

  ng.module('cookyii.filters', [])

    .filter('trustAsJs', ['$sce', trustAsJs])
    .filter('trustAsHtml', ['$sce', trustAsHtml])
    .filter('trustAsUrl', ['$sce', trustAsUrl])
    .filter('trustAsResourceUrl', ['$sce', trustAsResourceUrl])
    .filter('nl2br', nl2br)
    .filter('html2PlainText', html2PlainText)
    .filter('truncateCharacters', truncateCharacters)
    .filter('truncateSplitCharacters', truncateSplitCharacters)
    .filter('truncateWords', truncateWords);

  function trustAsJs($sce) {
    return function (val) {
      return $sce.trustAsJs(val);
    };
  }

  function trustAsHtml($sce) {
    return function (val) {
      return $sce.trustAsHtml(val);
    };
  }

  function trustAsUrl($sce) {
    return function (val) {
      return $sce.trustAsUrl(val);
    };
  }

  function trustAsResourceUrl($sce) {
    return function (val) {
      return $sce.trustAsResourceUrl(val);
    };
  }

  function nl2br() {
    return function (input) {
      if (typeof input === 'string') {
        return input.replace(/\n/g, '<br>');
      }
    };
  }

  function html2PlainText() {
    return function (text) {
      return text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
  }

  function truncateCharacters() {
    return function (input, chars, breakOnWord) {
      if (isNaN(chars)) return input;
      if (chars <= 0) return '';
      if (input && input.length > chars) {
        input = input.substring(0, chars);

        if (!breakOnWord) {
          var lastspace = input.lastIndexOf(' ');
          //get last space
          if (lastspace !== -1) {
            input = input.substr(0, lastspace);
          }
        } else {
          while (input.charAt(input.length - 1) === ' ') {
            input = input.substr(0, input.length - 1);
          }
        }
        return input + '…';
      }
      return input;
    };
  }

  function truncateSplitCharacters() {
    return function (input, chars) {
      if (isNaN(chars)) return input;
      if (chars <= 0) return '';
      if (input && input.length > chars) {
        var prefix = input.substring(0, chars / 2);
        var postfix = input.substring(input.length - chars / 2, input.length);
        return prefix + '...' + postfix;
      }
      return input;
    };
  }

  function truncateWords() {
    return function (input, words) {
      if (isNaN(words)) return input;
      if (words <= 0) return '';
      if (input) {
        var inputWords = input.split(/\s+/);
        if (inputWords.length > words) {
          input = inputWords.slice(0, words).join(' ') + '…';
        }
      }
      return input;
    };
  }
}(angular));
