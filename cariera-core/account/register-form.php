<?php

/**
 *
 * @package Cariera
 *
 * @since    1.5.2
 * @version  1.5.2
 * 
 * ========================
 * CARIERA REGISTER FORM TEMPLATE
 * ========================
 *     
 **/



// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

wp_enqueue_script('cariera-user-ajax');

do_action('cariera_register_form_before');

echo do_shortcode('[gravityform id="1" title="false" ajax="true" /]');

do_action('cariera_register_form_after');

?>
<!-- Direct url toggle -->
<script>
    'use strict';
    jQuery('document').ready(function($) {
        if (window.location.href.includes("#delivery-client")) {
            $("#choice_1_7_1").prop('checked', true);
        }
    });
</script>