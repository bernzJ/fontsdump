<?php

/**
 *
 * @package Cariera
 *
 * @since    1.4.6
 * @version  1.5.3
 * 
 * ========================
 * RESUME OVERVIEW
 * ========================
 *     
 **/



if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

global $post;
?>



<!-- Start of Candidate Overview -->
<h5><?php esc_html_e('Candidate Overview', 'cariera'); ?></h5>
<aside class="widget widget-candidate-overview">

  <?php do_action('single_resume_meta_start'); ?>

  <div class="single-resume-overview-detail single-resume-overview-occupation">
    <div class="icon">
      <i class="fas fa-truck"></i>
    </div>

    <div class="content">
      <h6><?php esc_html_e('Brand Of Vehicle', 'cariera'); ?></h6>
      <span>
        <?php
        $model_id = get_post_meta($post->ID, '_vehicle_model', true);
        $vehicle_term = get_term_by('id', $model_id, 'vehicle_brand');
        echo $vehicle_term->name;
        ?>
      </span>
    </div>
  </div>

  <?php

  $mileage = get_post_meta($post->ID, '_vehicle_mileage', true);
  if (!empty($mileage)) { ?>
    <div class="single-resume-overview-detail single-resume-overview-rate">
      <div class="icon">
        <i class="fas fa-tachometer-alt"></i>
      </div>

      <div class="content">
        <h6><?php esc_html_e('Vehicle Mileage', 'cariera'); ?></h6>
        <span><?= esc_html($mileage) ?></span>
      </div>
    </div>
  <?php } ?>


  <?php do_action('single_resume_meta_end'); ?>
</aside>