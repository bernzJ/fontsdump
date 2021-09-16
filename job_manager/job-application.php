<?php

/**
 * Show job application when viewing a single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-application.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @version     1.31.1
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}
?>

<?php if ($apply = get_the_job_application_method()) :
  wp_enqueue_script('wp-job-manager-job-application');
?>

  <div class="job_application application">

    <!-- Display Login to apply button for logged out users -->
    <?php
    $user = wp_get_current_user();
    $login_status = is_user_logged_in();

    if (!$login_status) : ?>
      <a id="login-btn" href="#login-register-popup" class="application_button btn btn-main btn-effect popup-with-zoom-anim"><?php esc_html_e('Login to Apply', 'cariera'); ?></a>
    <?php endif; ?>

    <?php do_action('job_application_start', $apply); ?>

    <!-- Check if driver is subscribed then give access to apply to the job-->

    <?php

    if (in_array('subscribed_driver', (array)$user->roles)) : ?>

      <a href="#job-popup" class="application_button btn btn-main btn-effect popup-with-zoom-anim"><?php esc_html_e('Apply on contract', 'cariera'); ?></a>
      <div id="job-popup" class="small-dialog zoom-anim-dialog mfp-hide">
        <div class="job-app-msg">
          <div class="small-dialog-headline">
            <h3 class="title"><?php esc_html_e('Apply on contract', 'cariera') ?></h3>
          </div>
          <div class="small-dialog-content">
            <?php
            /**
             * job_manager_application_details_email or job_manager_application_details_url hook
             */
            do_action('job_manager_application_details_' . $apply->type, $apply);
            ?>
          </div>
        </div>
      </div>

    <?php elseif (in_array('candidate', (array)$user->roles)) : ?>
      <a id="subscribe-btn" href="javascript:void(0)" class="application_button btn btn-main btn-effect" onclick="onSubscribeClick()"><?php esc_html_e('Apply on contract', 'cariera'); ?></a>

    <?php endif; ?>

    <!-- Alert for unsubscribed drivers -->
    <template id="susbcribe">
      <swal-title>
        <?= esc_html_e('Subscribe to apply on this contract', 'cariera') ?>
      </swal-title>
      <swal-icon type="info" color=var(--cariera-primary)></swal-icon>
      <swal-button type="confirm">
        <?= esc_html_e('Subscribe Now', 'cariera') ?>
      </swal-button>
      <swal-button type="cancel">
        <?= esc_html_e('Cancel', 'cariera') ?>
      </swal-button>
      <swal-param name="allowEscapeKey" value="true" />
    </template>

    <script>
      const onSubscribeClick = () =>
        Swal.fire({
          template: '#susbcribe',
          type: "confirm"
        }).then(({
          isConfirmed
        }) => isConfirmed && (window.location.href = "/checkout?add-to-cart=6320"));
    </script>

    <?php do_action('job_application_end', $apply); ?>
  </div>

<?php endif; ?>