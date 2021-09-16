<?php

/**
 * Single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.28.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// // $is_form_submitted = $_POST['job_id'];
// $is_form_submitted = $_POST['job_id'];
// $submitted = $_GET['application_success'];

// if(isset($is_form_submitted) || $submitted == '1' ) : 
//    include 'thankyou.php';
// else :


global $post;

// Check User has access to see the content  

$submitted_applications = [];
$post_id = $post->ID;


$image = get_post_meta($post->ID, '_job_cover_image', true);
$types = wpjm_get_the_job_types();



$args = array(
    'post_type'           => 'job_application',
    'post_status'         => array_keys(get_job_application_statuses()),
    'meta_key'            => '_candidate_user_id',
    'meta_value'          => get_current_user_id(),
    'post_per_page'       => -1
);
$applications = new WP_Query($args);

if ($applications->have_posts()) :
    while ($applications->have_posts()) :
        $applications->the_post();
        $submitted_application = get_post();
        $application_id = $submitted_application->ID;
        $job_id = $submitted_application->post_parent;
        $application_status = $submitted_application->post_status;
        $submitted_applications += ["$job_id" => $application_id];
    endwhile;

endif;
wp_reset_postdata();

$current_user_application_id = $submitted_applications[$post_id];
$current_user_application = get_post($current_user_application_id);
$current_user_application_status = $current_user_application->post_status;
$has_access = $current_user_application_status === 'hired';


if (!$has_access) {
    // @TODO: Don't hardcode urls & move this to a wordpress field.
    $image = 'https://goxchain.stage.surf/wp-content/uploads/job-manager-uploads/picture_slide/2021/06/HOLIDAY.png';
}

if (!empty($image)) { ?>
    <section class="page-header page-header-bg job-header" style="background: url(<?php echo esc_attr($image); ?>);">
    <?php } else { ?>
        <section class="page-header job-header">
        <?php } ?>


        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <h1 class="title pb15"><?php the_title(); ?></h1>
                    <?php if ($has_access) : ?>
                        <span class="job-type new-job-tag">Accepted</span>
                    <?php endif  ?>
                    <?php
                    if (!empty($types)) {
                        foreach ($types as $type) { ?>
                            <span class="job-type <?php echo esc_attr(sanitize_title($type->slug)); ?>"><?php echo esc_html($type->name); ?></span>
                    <?php }
                    }

                    if (cariera_newly_posted()) { //If job is new than show the new tag
                        echo '<span class="job-type new-job-tag">' . esc_html__('New', 'cariera') . '</span>';
                    } ?>
                </div>

                <!-- Start of Bookmark -->
                <div class="col-md-6 col-xs-12 bookmark-wrapper">
                    <?php do_action('cariera_bookmark_hook'); ?>
                </div>
                <!-- End of Bookmark -->

            </div>
        </div>
        </section>



        <!-- ===== Start of Main Wrapper ===== -->
        <main class="ptb80">
            <div class="container">
                <div class="row">
                    <?php
                    do_action('cariera_single_job_listing_before');


                    $jobs_layout = cariera_get_option('cariera_single_job_layout');

                    if ('left-sidebar' == $jobs_layout) {
                        $layout = 'col-md-8 col-md-push-4 col-xs-12';
                    } elseif ('right-sidebar' == $jobs_layout) {
                        $layout = 'col-md-8 col-xs-12';
                    }


                    // Show if Job has expired
                    if (get_option('job_manager_hide_expired_content', 1) && 'expired' === $post->post_status) { ?>
                        <div class="col-md-12">
                            <div class="job-manager-message error"><?php esc_html_e('This listing has expired.', 'cariera'); ?></div>
                        </div>
                    <?php } else { ?>

                        <!-- ===== Start of Job Details ===== -->
                        <div class="<?php echo esc_attr($layout); ?>">
                            <div class="single-job-listing">
                                <?php if ($has_access) : ?>
                                    <?php
                                    /**
                                     * single_job_listing_start hook
                                     *
                                     * @hooked job_listing_meta_display - 20
                                     * @hooked job_listing_company_display - 30
                                     */
                                    do_action('single_job_listing_start');
                                    ?>
                                <?php else : ?>
                                    <?php $check_field = get_post_meta($post_id, '_filled');
                                    if ($check_field[0] == 1) : ?>
                                        <div class="job-manager-message success position-filled">
                                            <?= esc_attr_e('This position has been filled', 'cariera') ?>
                                        </div>
                                    <?php endif;  ?>
                                    <div class="company-info">
                                        <p class="hidden-reason">
                                            <?= esc_attr_e('Company details are hidden until your application is approved', 'cariera') ?>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <div class="job-description">
                                    <?php wpjm_the_job_description(); ?>
                                </div>

                                <?php
                                /**
                                 * single_job_listing_end hook
                                 */
                                do_action('single_job_listing_end');
                                ?>
                            </div>

                        </div>
                        <!-- ===== End of Job Details ===== -->

                    <?php get_sidebar('single-job');
                    }


                    do_action('cariera_single_job_listing_after');
                    ?>
                </div>
            </div>
        </main>
        <!-- ===== End of Main Wrapper ===== -->