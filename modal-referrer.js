jQuery( document ).ready(function() {

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


})
