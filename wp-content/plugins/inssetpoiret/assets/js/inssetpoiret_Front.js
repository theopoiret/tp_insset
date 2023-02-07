( ( $ ) => {

  $( document ).ready( ( ) => {

      $( "#formulaire" ).submit( ( e ) => {

          e.stopPropagation();
          e.preventDefault();

          const formData = new FormData();
          formData.append( 'action', 'inssetpoiret' );
          formData.append( 'security', inssetscript.security );

          $( "#formulaire" ).find( 'input, textarea, select' ).each( ( i, e ) => e.id && formData.append( e.id, e.value ) );
          jQuery('#loading').show();
          jQuery.ajax({
              url: inssetscript.ajax_url,
              xhrFields: {
                  withCredentials: true
              },
              cache: false,
              contentType: false,
              processData: false,
              data: formData,
              type: 'post',
              success: function( rs, textStatus, jqXHR ) {
                  jQuery("#loading").hide();
                  return false;
              }
          })
      } );

  });

})( jQuery );
