(function ($) {
  'use strict'
  $( "#expenditure_dt" ).datepicker({
    dateFormat: "yy-mm-dd",
  });
  $( "#trns_date" ).datepicker({
    dateFormat: "yy-mm-dd",
  });
  $("#send").click(function()
    { 
  $.ajax({
    method: "POST",
    url: "http://localhost/unitedwayhyd/index.php/eightyg/pdfemail",
    data: { name: "John", location: "Boston" }
  })
    .done(function( msg ) {
      alert( "Data Saved: " + msg );
    });
});
})(jQuery)
