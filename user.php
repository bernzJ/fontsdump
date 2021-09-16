<?php

namespace Cariera_Child;

include get_stylesheet_directory() . '/remove-class.php';

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

class Cariera_Core_User
{

  public function __construct()
  {
    // Cleanup
    remove_class_hook('wp_ajax_nopriv_cariera_ajax_forgotpass', 'Cariera_Core_User', 'forgot_pass_process');

    // New hooks

    // Login, Register, Foget Password AJAX Functions
    add_action('wp_ajax_nopriv_cariera_ajax_forgotpass', [$this, 'forgot_pass_process']);

    // Shortcodes
    add_shortcode('cariera_forgetpass_form', [$this, 'forgetpass_form']);
  }

  public static function register_message($user)
  {
    $approval = get_option('cariera_moderate_new_user');

    if ($approval == 'email') {
      return esc_html__('Registration complete! Before you can login you must activate your account via the email sent to you.', 'cariera');
    } elseif ($approval == 'admin') {
      return esc_html__('Registration complete! Your account has to be activated by an admin before you can login.', 'cariera');
    } else {
      return esc_html__('Your account has to be activated.', 'cariera');
    }
  }

  /**
   * AJAX Forgot Password function
   *
   * @since 1.4.8
   */
  public function forgot_pass_process()
  {
    // First check the nonce, if it fails the function will break
    check_ajax_referer('cariera-ajax-forgetpass-nonce', 'forgetpass-security');

    global $wpdb;

    $account = isset($_POST['forgot_pass']) ? $_POST['forgot_pass'] : '';

    // Account checks
    if (empty($account)) {
      $error = esc_html__('Enter a Email address.', 'cariera');
    } else {
      if (is_email($account)) {
        if (email_exists($account)) {
          $get_by = 'email';
        } else {
          $error = esc_html__('There is no user registered with that Email address.', 'cariera');
        }
      } else {
        $error = esc_html__('Invalid e-mail address.', 'cariera');
      }
    }


    // If no error
    if (empty($error)) {
      $random_password = wp_generate_password();
      $user          = get_user_by($get_by, $account);
      $update_user     = wp_update_user(['ID' => $user->ID, 'user_pass' => $random_password]);

      if ($update_user) {

        /***** Mail Content *****/
        $subject = esc_html__('Password Reset', 'cariera');

        ob_start();
        get_template_part('/templates/emails/header'); ?>

        <tr>
          <td class="h2"><?php printf(esc_html__('Hello %s,', 'cariera'), $user->user_login); ?></td>
        </tr>
        <tr>
          <td><?php esc_html_e('Your password has been resetted successfully. You can log in on your account with the newly generated password provided below.', 'cariera'); ?></td>
        </tr>
        <tr>
          <td style="padding-top: 15px;"><?php printf(esc_html__('Your new password is: %s', 'cariera'), $random_password); ?></td>
        </tr>

    <?php
        get_template_part('/templates/emails/footer');
        $content = ob_get_clean();

        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        wp_mail($user->user_email, $subject, $content, $headers);

        $success = esc_html__('Go to your inbox and get your new generated password.', 'cariera');
      } else {
        $error = esc_html__('Something went wrong while updating your account.', 'cariera');
      }
    }

    if (!empty($error)) {
      echo json_encode([
        'loggedin'  => false,
        'message'  => '<span class="job-manager-message error">' . $error . '</span>',
      ]);
    }

    if (!empty($success)) {
      echo json_encode([
        'loggedin'   => true,
        'message'  => '<span class="job-manager-message success">' . $success . '</span>',
      ]);
    }

    die();
  }


  /**
   * Forget Password Form Shortcode
   *
   * @since  1.4.8
   */
  public function forgetpass_form()
  {
    if (is_user_logged_in()) {
      return;
    } ?>

    <form id="cariera_forget_pass" action="#" method="post">
      <p class="status"></p>

      <div class="form-group">
        <label for="forgot_pass"><?php esc_html_e('Email Address *', 'cariera'); ?></label>
        <input id="forgot_pass" type="text" name="forgot_pass" class="form-control" placeholder="<?php esc_html_e('Your Email Address', 'cariera'); ?>" />
      </div>

      <div class="form-group">
        <input type="submit" name="submit" value="<?php esc_html_e('Reset Password', 'cariera'); ?>" class="btn btn-main btn-effect nomargin" />
      </div>

      <?php wp_nonce_field('cariera-ajax-forgetpass-nonce', 'forgetpass-security'); ?>
    </form>
<?php
  }
}

new \Cariera_Child\Cariera_Core_User();
