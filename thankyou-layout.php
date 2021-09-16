<?php

/**
 * Template Name: Thank you page
 *
 */

if (!wp_get_referer()) {
  wp_safe_redirect(home_url());
}

get_header();
?>

<style>
  .bg-blue {
    padding: 50px;
  }

  .related-jobs {
    display: none;
  }

  .thank-title {
    color: var(--cariera-primary);
    font-family: 'Poppins';
    font-weight: 600;
  }

  .bg-section {
    min-height: 80vh;
  }

  .thankyou-section {
    position: relative;
  }

  .lorry-bottom {
    position: absolute;
    bottom: 0;
    width: 40%;
    right: 1em;
  }
</style>
<?php
$job_id = $_GET['job-id'];
$job_title = get_post_meta($job_id, 'post_title');
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);
?>

<section class="container thankyou-section">
  <div class="jumbotron bg-blue bg-section text-center">
    <img class="" src="/wp-content/uploads/2021/08/icons8-ok.svg" alt="">
    <h2 class="thank-title text-center"><?= esc_html_e('Thank you', 'cariera') ?></h2>
    <h5 class="text-center">
      <?= esc_html_e('You have successfully submitted to', 'cariera') ?>
      <strong>
        <?= get_the_title($job_id);  ?>
      </strong>
    </h5>
    <div>
      <strong><?= esc_html_e('A confirmation email has been sent to ' . $user_data->user_email, 'cariera'); ?></strong>
    </div>
    <div>
      <?= the_content() ?>
    </div>

  </div>
  <img class="lorry-bottom" src="/wp-content/uploads/2021/08/AdobeStock_195848826-Converted-2.png" alt="lorry">
</section>

<?php get_footer(); ?>