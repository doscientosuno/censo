'use strict';
(function() {
  var campus = document.querySelector('[data-campus]');
  var options = document.querySelectorAll('[data-center]');
  [].forEach.call(options, function(o) {
    o.style.display = 'none';
  });
  if (campus) {
    campus.addEventListener('change', function(e) {
      var query = '[data-center="' + campus.value + '"]';
      var options = document.querySelectorAll(query);
      [].forEach.call(options, function(o) {
        o.style.display = 'block';
      });
    });
  } 

})();
