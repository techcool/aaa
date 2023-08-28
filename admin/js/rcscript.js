jQuery(document).on('click', '#rcupload', function(e){
    e.preventDefault();
    let self = this;
    jQuery(self).prop("disabled",true);
    var fd = new FormData();
    var file = jQuery(document).find('input[type="file"]');
    var caption = jQuery(this).find('input[name=rcfile]');
    var individual_file = file[0].files[0];
    if(jQuery('.rcfile').val() != ''){
        fd.append("file", individual_file);
        var individual_capt = caption.val();
        fd.append("caption", individual_capt); 
        fd.append('dataType', 'json'); 
        fd.append('action', 'do_read');  
        jQuery.ajax({
            type: 'POST',
            url: rc_object.ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            beforeSend: function() {
                  jQuery(".loader-wrap").show();
                  jQuery('.loader-wrap')[0].scrollIntoView()
               },
            success: function(response){
                jQuery(".loader-wrap").hide();
                jQuery('.put-data').html(response);
                jQuery('#allRcData').DataTable();
            },
            complete: function(data) {
                jQuery(self).prop("disabled",false);
            }
        });
    }else{
        jQuery('.upload-erre').show();
        window.setTimeout(function(){jQuery('.upload-erre').hide('slow');},2000);
    }
});
/* For Save */
jQuery(document).on('click', '#be-confirm-save', function(e){
    e.preventDefault();
    let self = this;
    jQuery(self).prop("disabled",true);
    var fd = new FormData();
    var fileName = jQuery(this).val();
    fd.append('action', 'do_save');  
    fd.append('fileName', fileName);
    jQuery.ajax({
        type: 'POST',
        url: rc_object.ajax_url,
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function() {
              jQuery(".loader-wrap").show();
           },
        success: function(response){
            jQuery(".loader-wrap").hide();
            jQuery('.put-data').html(response);
            window.setTimeout(function(){location.reload()},4000)
        },
        complete: function() {
            jQuery(self).prop("disabled",false);
        }
    });
    return false;
});
/* For Cancel */
jQuery(document).on('click', '#be-confirm-delete', function(){
    location.reload();
});
/* data-table */
jQuery(document).ready(function(){
    jQuery('#allRcSaveData').DataTable();
    jQuery('#allRcRejectedData').DataTable();
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
        } else {
          panel.style.display = "block";
        }
      });
    };

});  