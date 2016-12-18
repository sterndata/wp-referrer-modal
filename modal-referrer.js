jQuery( document ).ready(function() {
var ref = document.referrer;
if (ref.match(/^https?:\/\/([^\/]+\.)?wordpress\.org(\/|$)/i)) {
  jQuery( function() {
    jQuery( "#sdsModal" ).dialog({
      modal: true,
      show: true,
      width: 500,
      buttons: {
        Ok: function() {
          jQuery( this ).dialog( "close" );
        }
      }
    });
  } ); 
} // if ref.match

})
