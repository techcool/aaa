/*Front-end*/
jQuery('#rc-state').on('change', function(e){
    e.preventDefault();
    var pluginUrl = '<?=plugins_url();?>/rate-calculator/include/ajax.php';
    var fd = new FormData();
    var stateName = jQuery(this).val();
    fd.append('action', 'load_county');
    fd.append('stateName', 'stateName');

    jQuery.ajax({
        type: 'POST',
        url: pluginUrl,
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            jQuery(".loader").hide();
            jQuery('.put-data').html(response);
        }
    });
})
