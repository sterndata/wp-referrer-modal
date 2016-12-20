jQuery( document ).ready(function() {
var ref = document.referrer;
if (ref.match(/^https?:\/\/([^\/]+\.)?wordpress\.org(\/|$)/i)) {
  jQuery( function() {
    jQuery( "#sdsModal").css("display", "block");
    jQuery( "#sdsModal" ).dialog({
      modal: true,
      show: true,
      width: 'auto',
      maxWidth: '80%',
      buttons: {
        Ok: function() {
          jQuery( this ).dialog( "close" );
        }
      }
    });
  } ); 
} // if ref.match

})
