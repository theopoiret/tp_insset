jQuery(document).ready(function (s) {
jQuery('#v_utilisateur').on('click', function(e){
  e.stopPropagation();
  e.preventDefault();

  let formData = new FormData();
  formData.append('security', inssetfrontscript.security);

  let prenom = jQuery("#firstname").val();
  let nom = jQuery("#username").val();
  let genre = jQuery("#genre").val();
  let email = jQuery("#email").val();
  let date = jQuery("#date").val();
  formData.append('action', 'formuti');

  if( (prenom != "") && (nom != "") && (genre != "") && (email != "") && (date != "")){
    formData.append('prenom', prenom);
    formData.append('nom', nom);
    formData.append('genre', genre);
    formData.append('email', email);
    formData.append('date', date);
    formData.append('error', "No error");
  }
  else{
    formData.append('prenom', null);
    formData.append('nom', null);
    formData.append('genre', null);
    formData.append('email', null);
    formData.append('date', null);
    formData.append('error', "error");
  }

  jQuery.ajax({
    url: inssetfrontscript.ajax_url,
    xhrFields: {
        withCredentials: true
    },
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    type: 'post',
    success: function(reponse){ 
      console.log(reponse);
      if(reponse != "error")
        window.location.replace("http://localhost/wordpress/pays/?id="+reponse);

      return false;
    },
    error: function(reponse){
      console.log(reponse);
      return false;
    }

  })
})

jQuery('#pays_valider').on('click', function(e){
  e.stopPropagation();
  e.preventDefault();

  let formData = new FormData();
  formData.append('security', inssetfrontscript.security);

  var pays_selec = null;
  for(var boucle = 0 ; boucle < document.getElementsByClassName('slct_pays').length ; boucle++){
    if( document.getElementsByClassName('slct_pays')[boucle].value == "Rien" )
      boucle = document.getElementsByClassName('slct_pays').length;
    else{
      if(pays_selec == null)
        pays_selec = document.getElementsByClassName('slct_pays')[boucle].value;
      else
        pays_selec += ","+document.getElementsByClassName('slct_pays')[boucle].value;
    }
  }
  formData.append('action', 'formpays');

  if(pays_selec != null){
    formData.append('pays_list', pays_selec);
    formData.append('Id_User', window.location.href.slice(window.location.href.indexOf('=')).split('=')[1]);
    formData.append('Error', "no error");
  }
  else{
      formData.append('pays_list', null);
      formData.append('Id_User', null);
      formData.append('Error', "No country selected");
  }
  jQuery.ajax({
    url: inssetfrontscript.ajax_url,
    xhrFields: {
        withCredentials: true
    },
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    type: 'post',
    success: function(reponse){ 
      if(reponse != 'error')
        window.location.replace("http://localhost/wordpress/recapitulatif/?id="+reponse);

      return false;
    },
    error: function(reponse){
      console.log(reponse);
      return false;
    }
  })
})

jQuery('.slct_pays').on('change', function(e){
  e.stopPropagation();
  e.preventDefault();

  var verif_value = 0;

  for(var boucle = 0 ; boucle < document.getElementsByClassName('slct_pays').length ; boucle++){

      if( (document.getElementsByClassName('slct_pays')[boucle].value != "Rien") && (boucle == verif_value)){
          document.getElementsByClassName('slct_pays')[boucle+1].hidden = false;
          verif_value++;
      }
      else{
          document.getElementsByClassName('slct_pays')[boucle+1].hidden = true;
          document.getElementsByClassName('slct_pays')[boucle+1].value = "Rien";
      }
  }
})

jQuery('#resume_valider').on('click', function(e){
  e.stopPropagation();
  e.preventDefault();
  let formData = new FormData();
  formData.append('security', inssetfrontscript.security);

  formData.append('action', 'formresume');
  formData.append('Id_User', window.location.href.slice(window.location.href.indexOf('=')).split('=')[1]);

  jQuery.ajax({
    url: inssetfrontscript.ajax_url,
    xhrFields: {
        withCredentials: true
    },
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    type: 'post',
    success: function(reponse){ 
      formData.append('data', reponse);
      let hbs = jQuery('#Script_Modal').attr('src');
      jQuery.ajax({
        dataType: "html",
        url: hbs,

        success: function(source){
          var modal = Handlebars.compile(source);
          jQuery("#Modal").html(modal(JSON.parse(reponse)));

          document.getElementById('Modal').style.display = "block";

          jQuery('#submit_valider').on('click', function(e){
            window.location.replace("http://localhost/wordpress/utilisateur/?id="+window.location.href.slice(window.location.href.indexOf('=')).split('=')[1]);
          });
        }
      
      })
    },
    error: function(reponse){
      console.log(reponse);
      return false;
    }
  })

})

});

