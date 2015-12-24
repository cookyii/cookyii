function defaultHttpErrorHandler(error, status) {
  if (typeof error !== 'undefined') {
    console.log('Error ' + status, error.message);
  } else {
    console.log('Unknown Error');
  }
}

function str_repeat(input, multiplier) {
  // Repeat a string
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

  var buf = '';

  for (var i = 0; i < multiplier; i++) {
    buf += input;
  }

  return buf;
}

function strpos(haystack, needle, offset) {
  var i = haystack.indexOf(needle, offset); // returns -1

  return i >= 0 ? i : false;
}
