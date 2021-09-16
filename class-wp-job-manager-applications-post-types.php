<?php

namespace Cariera_Child;

if (!defined('ABSPATH')) {
  exit;
}

class WP_Job_Manager_Applications_Post_Types
{
  public function __construct()
  {
    add_action('transition_post_status', [$this, 'transition_post_status'], 10, 3);
  }

  /**
   * When the status changes
   * https://since1979.dev/wordpress-access-post-meta-fields-through-wp-post/
   */
  public function transition_post_status($new_status, $old_status, $post)
  {
    if ('job_application' !== $post->post_type || $new_status !== 'hired') {
      return;
    }
  }
}

new \Cariera_Child\WP_Job_Manager_Applications_Post_Types();
