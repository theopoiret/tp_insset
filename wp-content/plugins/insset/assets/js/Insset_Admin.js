jQuery(document).ready(function () {
  console.log("ready!");
});

jQuery(document).ready(function () {
  // jQuery(".deleteButton").on("onclick", function (e) {
  jQuery(".deleteButton").click(function (e) {
    console.log("oooooo");
    console.log(e);
    e.stopPropagation();
    e.preventDefault();

    let _this = jQuery(this);

    let datas = {
      action: "inssetdelete",
      security: inssetadminscript.security,
      id: jQuery(this).data("id"),
    };

    jQuery.post(ajaxurl, datas, function (rs) {
      console.log(rs);
      _this.closest("tr").fadeOut("slow");
      jQuery(".is-dismissible").show("slow");

      setTimeout(() => {
        jQuery(".is-dismissible").hide("slow");
      }, "3000");
      return false;
    });

    // let formData = new FormData();
    // formData.append("action", "inssetdelete");
    // formData.append("security", inssetadminscript.security);
    // formData.append("id", jQuery(this).data("id"));
    // jQuery(this).attr('data-id')

    // jQuery.ajax({
    //   url: ajaxurl,
    //   xhrFields: {
    //     withCredentials: true,
    //   },
    //   cache: false,
    //   contentType: false,
    //   processData: false,
    //   data: formData,
    //   type: "post",
    //   success: function (rs, textStatus, jqXHR) {
    //     console.log(rs);
    //     return false;
    //   },
    // });

    // jQuery.ajax({
    //   url: inssetadminscript.ajax_url,
    //   xhrFields: {
    //     withCredentials: true,
    //   },
    //   cache: false,
    //   contentType: false,
    //   processData: false,
    //   type: "post",
    //   success: function (rs, textStatus, jqXHR) {
    //     console.log(rs);
    //     jQuery("#loading").hide();
    //     return false;
    //   },
    // });
  });

  jQuery("#submitConfigForm").click(function (e) {
    console.log("eventClick :");
    console.log(e);
    e.stopPropagation();
    e.preventDefault();

    let formData = new FormData();
    formData.append("action", "inssetconfig");
    formData.append("security", inssetadminscript.security);

    jQuery("#list-table input").each(function (i) {
      let id = jQuery(this).attr("id");
      let val = jQuery(this).val();
      if (typeof id !== "undefined") formData.append(id, val);
    });

    console.log(formData);

    jQuery.post({
      url: ajaxurl,
      xhrFields: {
        withCredentials: true,
      },
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: "post",
      success: function (rs, textStatus, jqXHR) {
        console.log("ajax success response");
        console.log(rs);
        if (rs == "update done") {
          jQuery(".is-dismissible").show("slow");

          setTimeout(() => {
            jQuery(".is-dismissible").hide("slow");
          }, "3000");
          return false;
        } else {
          alert(rs);
        }
      },
    });
  });
});
