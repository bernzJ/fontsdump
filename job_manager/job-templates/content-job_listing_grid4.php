<?php

/**
 *
 * @package Cariera
 *
 * @since    1.5.3
 * @version  1.5.3
 * 
 * ========================
 * JOB LISTING CONTENT - GRID VER. 4
 * ========================
 *     
 **/




global $post;
$job_class = 'job-grid single_job_listing_4 col-lg-4 col-md-6 col-xs-12';

$job_id     = get_the_ID();
$company    = get_post(cariera_get_the_company());
$logo       = get_the_company_logo();
$featured   = get_post_meta($job_id, '_featured', true) == 1 ? 'featured' : '';

$args = array(
  'post_status'         => 'Hired',
  'post_type'           => 'job_application',
  'meta_key'            => '_candidate_user_id',
  'meta_value'          => get_current_user_id(),
  'post_parent'         => $job_id
);

$has_access = !empty(get_posts($args));

if (!empty($logo) && $has_access) {
  $logo_img = $logo;
} else {
  $logo_img = apply_filters('job_manager_default_company_logo', get_template_directory_uri() . '/assets/images/company.png');
} ?>



<li <?php job_listing_class(esc_attr($job_class)); ?> data-latitude="<?php echo esc_attr($post->geolocation_lat); ?>" data-longitude="<?php echo esc_attr($post->geolocation_long); ?>" data-thumbnail="<?= $has_access ? esc_attr($logo_img) : "" ?>" data-id="listing-id-<?php echo get_the_ID(); ?>" data-featured="<?php echo esc_attr($featured); ?>">
  <a href="<?php the_permalink(); ?>">

    <!-- Job Info Wrapper -->
    <div class="job-info-wrapper">
      <?php if ($has_access) : ?>
        <div class="logo-wrapper">
          <?php
          // Company Logo                    
          if (!empty($company) && has_post_thumbnail($company)) {
            $logo = get_the_company_logo($company, apply_filters('cariera_company_logo_size', 'thumbnail'));
            echo '<img class="company_logo" src="' . esc_url($logo) . '" alt="' . esc_attr(get_the_company_name($company)) . '" />';
          } else {
            cariera_the_company_logo();
          }
          ?>
        </div>
      <?php endif; ?>

      <div class="job-info">
        <h5 class="title">
          <?php the_title(); ?>
          <?php do_action('cariera_job_listing_status'); ?>
        </h5>

        <ul>
          <li class="location"><i class="icon-location-pin"></i><?php the_job_location(false); ?></li>

          <?php if (get_post_meta($post->ID, '_salary_min', true)) { ?>
            <li class="salary"><i class="far fa-money-bill-alt"></i><?php cariera_job_salary(); ?></li>
          <?php } ?>

          <?php if (empty(get_post_meta($post->ID, '_salary_min', true))) {
            if (get_post_meta($post->ID, '_rate_min', true)) { ?>
              <li class="rate"><i class="far fa-money-bill-alt"></i><?php cariera_job_rate(); ?></li>
          <?php }
          } ?>
        </ul>
      </div>
    </div>

    <!-- Job Extras -->
    <div class="job-extras">
      <?php
      $job_types = [];
      $types     = wpjm_get_the_job_types();

      if (!empty($types)) {
        foreach ($types as $type) {
          $job_types[] = $type->name;
        }
      } ?>

      <div class="job-type-icon"></div>
      <span class="job-types"><?php echo esc_html(implode(', ', $job_types)); ?></span>
    </div>
  </a>
</li>