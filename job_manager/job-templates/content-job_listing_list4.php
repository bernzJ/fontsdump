<?php

/**
 *
 * @package Cariera
 *
 * @since    1.2.5
 * @version  1.5.0
 * 
 * ========================
 * JOB LISTING CONTENT - LIST VER. 4
 * ========================
 *     
 **/



global $post;

$job_class = 'job-list single_job_listing_4';

$job_id     = get_the_ID();
$company    = get_post(cariera_get_the_company());
$logo       = get_the_company_logo();
$featured   = get_post_meta($job_id, '_featured', true) == 1 ? 'featured' : '';
$submitted_applications = [];



$args = array(
    'post_type'           => 'job_application',
    'meta_key'            => '_candidate_user_id',
    'meta_value'          => get_current_user_id(),
    'post_per_page'       => -1
);
$applications = query_posts($args);

foreach ($applications as $application) :
    $application_id = $application->ID;
    $this_job_id = $application->post_parent;
    $submitted_applications += ["$this_job_id" => $application_id];
endforeach;

$current_user_application_id = $submitted_applications[$job_id];
$current_user_application = get_post($current_user_application_id);
$current_user_application_status = $current_user_application->post_status;
$has_access = $current_user_application_status === 'hired';

// @TODO: move this to a wordpress field.
$placeholder = apply_filters('job_manager_default_company_logo', get_template_directory_uri() . '/assets/images/company.png');
$logo_img = $has_access && !empty($logo) ? $logo : $placeholder;

?>
<li <?php job_listing_class(esc_attr($job_class)); ?> data-latitude="<?php echo esc_attr($post->geolocation_lat); ?>" data-longitude="<?php echo esc_attr($post->geolocation_long); ?>" data-thumbnail="<?php echo esc_attr($logo_img); ?>" data-id="listing-id-<?php echo get_the_ID(); ?>" data-featured="<?php echo esc_attr($featured); ?>">

    <?php
    // Show featured badge if job is featured
    if (is_position_featured($post->ID)) {
        echo '<span class="featured-badge">' . esc_html__('featured', 'cariera') . '</span>';
    } ?>

    <div class="job-content-wrapper">
        <?php
        $id = get_post_meta($post->ID, 'cariera_job_page_header', true);

        // Filtering the id to see if the image is uploaded from the backend or the frontend
        if (!$has_access) {
            $image = $placeholder;
        } elseif (filter_var($id, FILTER_VALIDATE_URL) === FALSE) {
            $image = wp_get_attachment_url($id);
        } else {
            $image = get_post_meta($post->ID, 'cariera_job_page_header', true);
        } ?>

        <!-- Listing Media -->
        <?php if ($has_access) : ?>
            <div class="listing-media">

                <?php if (!empty($id)) { ?>
                    <div class="job-company with-bg" style="background-image: url(<?php echo esc_attr($image); ?>);">
                    <?php } else { ?>
                        <div class="job-company">
                        <?php }

                    // Company Logo

                    // Make the logo link to the company if the core plugin is installed and activated
                    if (!empty($company)) { ?>
                            <a href="<?php echo esc_url(get_permalink($company)); ?>" title="<?php echo esc_attr__('Company page', 'cariera'); ?>">
                            <?php }
                        if (!empty($company) && has_post_thumbnail($company)) {
                            $alt =  esc_attr(get_the_company_name($company));
                            $logo = get_the_company_logo($company, apply_filters('cariera_company_logo_size', 'thumbnail'));

                            echo '<img class="company_logo" src="' . esc_url($logo) . '" alt="' . $alt . '" />';
                        } else {
                            cariera_the_company_logo();
                        }



                        if (!empty($company)) { ?>
                            </a>
                        <?php } ?>

                        <div class="tag-group">
                            <?php if (get_option('job_manager_enable_types')) {
                                $types = wpjm_get_the_job_types();
                                if (!empty($types)) {
                                    foreach ($types as $type) { ?>
                                        <span class="job-type <?php echo esc_attr(sanitize_title($type->slug)); ?>"><?php echo esc_html($type->name); ?></span>
                            <?php }

                                    if (cariera_newly_posted()) {
                                        echo '<span class="job-item-badge new-job">' . esc_html__('New', 'cariera') . '</span>';
                                    }
                                }
                            } ?>
                        </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Listing Body -->
                <div class="listing-body">
                    <div class="job-title">
                        <a href="<?php the_job_permalink(); ?>">
                            <h5 class="title">
                                <?php the_title(); ?>
                                <?php do_action('cariera_job_listing_status'); ?>
                            </h5>
                        </a>
                    </div>

                    <div class="job-info">
                        <?php do_action('job_listing_info_start'); ?>

                        <?php if (cariera_get_the_company()) { ?>
                            <span class="company">
                                <?php if ($has_access) : ?>
                                    <strong><?php esc_attr_e('Company: ', 'cariera'); ?></strong>
                                    <?php the_company_name(); ?>
                                <?php endif; ?>
                            </span>
                        <?php } ?>

                        <span class="location">
                            <?php if ($has_access) : ?>
                                <strong><?php esc_attr_e('Location: ', 'cariera'); ?></strong>
                                <?php the_job_location(false); ?>
                            <?php endif; ?>
                        </span>

                        <?php
                        $rate_min = get_post_meta($post->ID, '_rate_min', true);
                        if ($rate_min) {
                            $rate_max = get_post_meta($post->ID, '_rate_max', true);  ?>
                            <span class="rate">
                                <strong><?php esc_attr_e('Rate: ', 'cariera'); ?></strong>
                                <?php cariera_job_rate(); ?>
                            </span>
                        <?php } ?>

                        <?php
                        $salary_min = get_post_meta($post->ID, '_salary_min', true);
                        if ($salary_min) {
                            $salary_max = get_post_meta($post->ID, '_salary_max', true);  ?>
                            <span class="salary">
                                <strong><?php esc_attr_e('Salary: ', 'cariera'); ?></strong>
                                <?php cariera_job_salary(); ?>
                            </span>
                        <?php } ?>

                        <?php do_action('job_listing_info_end'); ?>
                    </div>

                    <div class="job-actions">
                        <?php
                        if (!$has_access) : ?>
                            <div class="badge badge-info"><?= esc_attr_e('Company details are hidden until your application is approved', 'cariera') ?> </div>
                        <?php endif; ?>
                        <span class="date"><?php the_job_publish_date(); ?></span>
                    </div>

                </div>

            </div>
</li>