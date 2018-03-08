jQuery(document).ready(function ($) {
    console.log('Include main file');
    $('.send-button').click(function () {

        $.ajax({
            url: tljJobImport.ajaxurl,
            type: 'POST',
            data: {
                action: 'doGetAdvertisementById',
                id: tljJobImport.id
            },
            success: function(response) {
                alert(response);
            },
            error: function (response) {
                alert('Fail');
            }
        });
    });
});