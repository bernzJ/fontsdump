jQuery(document).ready(function($) {
    let update_after_success = (text) => {
        text = text.replace(/\s/g, '')
        if (text === 'hired') {
            jQuery('.clicked').html(`<i class="far fa-times-circle"></i> Reject`);
            jQuery('.clicked').css('background', 'red');
            jQuery('.post-badge').html('Accepted');
            jQuery('.post-badge').css('background', 'green');
            jQuery('.clicked').data('action', 'rejected');
        } else {
            jQuery('.clicked').html(`<i class="far fa-check-square"></i> Approve`);
            jQuery('.clicked').css('background', 'green');
            jQuery('.post-badge').html('Rejected');
            jQuery('.post-badge').css('background', 'red');
            jQuery('.clicked').data('action', 'hired');
        }
    }
    $('.change-status').click(function() {
        $('.change-status').removeClass('clicked');
        $(this).addClass('clicked');
        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            dataType: 'html',
            data: {
                action: 'change_status',
                id: jQuery(this).data('id'),
                app_status: jQuery(this).data('action'),
            },
            beforeSend: function() {
                jQuery('.clicked').html('<i class="fas fa-spinner fa-pulse"></i>');
            },

            success: function(res) {
                update_after_success(res);
            }
        });
    });
});