'use strict';
(function() {
  var remove = function() {
    var options = document.querySelectorAll('[data-center]');
    [].forEach.call(options, function(o) {
      o.style.display = 'none';
    });
  };
  remove();

  var campus = document.querySelector('[data-campus]');

  if (campus !== undefined) {
    remove();
    campus.addEventListener('change', function(e) {
      console.log('Campus modificado. Cambiando centros disponibles.')
      var query = '[data-center="' + campus.value + '"]';
      console.log(query);
      var options = document.querySelectorAll(query);
      [].forEach.call(options, function(o) {
        o.style.display = 'block';
      });
    });
  }

})();
