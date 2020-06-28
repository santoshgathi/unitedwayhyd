(function ($) {
  'use strict'
  $( "#expenditure_dt" ).datepicker({
    dateFormat: "yy-mm-dd",
  });
  $( "#trns_date" ).datepicker({
    dateFormat: "yy-mm-dd",
  });
  $( "#appointmentdt" ).datepicker({
    dateFormat: "yy-mm-dd",
	minDate: -0,
	maxDate: "+2M +10D"
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
