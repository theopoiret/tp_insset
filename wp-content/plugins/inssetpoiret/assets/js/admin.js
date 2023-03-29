jQuery( document ).ready(function() {

    jQuery('.deleted').on('click', function(e) {

    //Empêche le reload de la page au submit du form
    e.stopPropagation();
    e.preventDefault();

//On garde le button
    var _this = jQuery(this);

//Création de la variable de transport de nos valeurs
    let formData = new FormData();
    formData.append('action', 'removeNewsletter');
    formData.append('security', inssetscript.security);
    formData.append('id',_this.data('id'));
    
//Envoie de la requête AJAX  (avec les données) au controller PHP pour traitement
    jQuery.ajax({
        url: ajaxurl,
        xhrFields: {
            withCredentials: true
        },
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        type: 'post',
        success: function(response) {
            _this.closest('tr').fadeOut('slow');
            jQuery('.delete-confirmation').removeClass('hide');
            console.log(response);
            return false;
        }
    });

    return false;

});
})