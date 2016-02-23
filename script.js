'use strict';
(function() {
  var body = document.querySelector('[data-body]');
  var campus = document.querySelector('[data-campus]');
  var campusVal = document.querySelector('[data-campus-value]');
  var center = document.querySelector('[data-center]');
  var showCampus = function() {
    campus.style.display = "none";
    if(body.value === "12") campus.style.display = "block";
  };
  var showCenter = function() {
    var campus = campusVal.value;
    center.style.display = "none";
    if(campus !== "") {
      center.style.display = "block";
      // Filtrado de centros
      var centers = document.querySelectorAll('[data-center] option');
      [].forEach.call(centers, function(c) {
        c.style.display = "none";
        if(campus === c.dataset.campusCenter) {
          c.style.display = "block";
        }
      });
    }
  };
  var upload = document.querySelector('[data-upload]');
  var checkFiles = function(e) {
    if(e.target.files[0].size > 3 * 1024 * 1024) {
      e.target.value = "";
      alert('El archivo supera el límite de 3MB.');
    }
  }
  var pw = document.querySelector('#pw');
  var pw2 = document.querySelector('#pw2');
  var checkPW = function() {
    if(pw.value !== pw2.value) {
      alert('Las contraseñas no coinciden.');
    }
  };

  showCampus();
  showCenter();
  body.addEventListener('change', showCampus);
  campusVal.addEventListener('change', showCenter);
  upload.addEventListener('change', checkFiles);
  pw2.addEventListener('change', checkPW);
})();
