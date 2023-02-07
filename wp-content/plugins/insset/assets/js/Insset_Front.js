jQuery(document).ready(function () {
  console.log("ready!");
});

jQuery(document).ready(function () {
  //   jQuery("#form").on("onsubmit", function (e) {
  //     console.log("oooooo");
  //     console.log(e);
  //     e.stopPropagation();
  //     e.preventDefault();

  jQuery("#form").submit(function (e) {
    e.stopPropagation();
    e.preventDefault();

    let formData = new FormData();
    formData.append("action", "inssetnewsletter");
    formData.append("security", inssetscript.security);

    jQuery("#form")
      .find("input, textarea, select")
      .each(function (i) {
        let id = jQuery(this).attr("id");
        if (typeof id !== "undefined") formData.append(id, jQuery(this).val());
      });

    jQuery("#loading").show();

    jQuery.ajax({
      url: inssetscript.ajax_url,
      xhrFields: {
        withCredentials: true,
      },
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      type: "post",
      success: function (rs, textStatus, jqXHR) {
        console.log(rs);
        jQuery("#loading").hide();
        return false;
      },
    });

    // let datas = {
    //   action: "inssetnewsletter",
    //   security: inssetscript.security,
    // };
    // jQuery.post(inssetscript.ajax_url, datas, function (rs) {
    //   alert(rs);
    // });

    // jQuery.post(inssetscript.ajax_url, formData, function (rs) {
    //   let formData = new FormData();
    //   formData.append("action", "inssetnewsletter");
    //   formData.append("security", inssetscript.security);
    //   console.log(rs);
    //   alert(rs);
    // });
    // return false;
  });
});
