<?php
include get_stylesheet_directory() . '/user.php';

add_action('wp_enqueue_scripts', 'cariera_child_enqueue_scripts', 20);
function cariera_child_enqueue_scripts()
{
	wp_enqueue_style('cariera-child-style', get_stylesheet_uri());
	wp_enqueue_style('custom', get_stylesheet_directory_uri() . '/assets/custom.css');
	wp_enqueue_script('sweetAlert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11');
	wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/custom.js');
}

// Add only one product to the cart 

add_filter('woocommerce_add_to_cart_validation', 'goxchain_only_one_in_cart', 9999, 2);

function goxchain_only_one_in_cart($passed, $added_product_id)
{
	wc_empty_cart();
	return $passed;
}




function application_approved($post_ID, $post_after, $post_before)
{
	if ($post_after->post_status == 'hired') :
		$to =	get_post_meta($post_ID, '_candidate_email')[0];
		$subject = 'Your Application Has Approved';
		$candidate_name = get_post_meta($post_ID, 'Full name')[0];
		$job_id = $post_after->post_parent;
		$job_link = get_permalink($job_id);
		$company_id = get_post_meta($job_id, '_company_manager_id')[0];
		$company_name = get_post_meta($company_id, '_company_name')[0];
		$company_phone = get_post_meta($company_id, '_company_phone')[0];
		$company_email = get_post_meta($company_id, '_company_email')[0];
		$company_lat = get_post_meta($company_id, 'geolocation_lat')[0];
		$company_long = get_post_meta($company_id, 'geolocation_long')[0];
		$headers = array('Content-Type: text/html; charset=UTF-8', 'From: GOXCHAIN <info@goxchain.com>');

		ob_start();
		include(get_stylesheet_directory() . '/job_manager/hired_email_content.php');
		$body = ob_get_contents();
		ob_get_clean();

		wp_mail($to, $subject, $body, $headers);
	endif;
}

add_action('post_updated', 'application_approved', 10, 3);



function application_created_send_email($post_id, $post, $update)
{
	if ($post->post_type == 'job_application') :
		$job_id = $post->post_parent;
		$user_info = get_userdata(get_current_user_id());
		//var_dump($post);
		$candidate_email = $user_info->user_email;
		$candidate_details = $post->post_title;;
		$company_id = get_post_meta($job_id, '_company_manager_id', true);
		$job_title = get_the_title($job_id);
		$job_link = get_permalink($job_id);
		$employer_email = 	get_post_meta($company_id, '_company_email', true);
		$subject_candidate = 'Application has been Submitted';
		$subject_employer = 'You have received new application';;

		//Template of Candidate 
		ob_start();
		include(get_stylesheet_directory() . '/job_manager/candidate_email_content.php');
		$candidate_message = ob_get_contents();
		ob_get_clean();

		// template of Employer 
		ob_start();
		include(get_stylesheet_directory() . '/job_manager/employer_email_content.php');
		$employer_message = ob_get_contents();
		ob_get_clean();

		$headers = array('Content-Type: text/html; charset=UTF-8', 'From: GOXCHAIN <info@goxchain.com>');

		// Send email to candidate
		wp_mail($candidate_email, $subject_candidate, $candidate_message, $headers);
		wp_mail($employer_email, $subject_employer, $employer_message, $headers);
		wp_safe_redirect(home_url("/thank-you-page/?job-id='$job_id'"));

	endif;
}

add_action('save_post', 'application_created_send_email', 10, 3);


function candidate_name_change()
{
	$current_user = wp_get_current_user();
	$firstname = $current_user->user_firstname;
	$lastname = $current_user->user_lastname; ?>
	<script>
		jQuery('#submit-resume-form').submit(function(e) {
			//alert('before_submit_call');
			let main_value = jQuery('#vehicle_type').val();
			let main_text = jQuery('#vehicle_type option[value="' + main_value + '"]').text();
			let sub_element = jQuery('#vehicle_type_' + main_value);
			let sub_value = jQuery(sub_element).val();
			let sub_text = jQuery('option[value="' + sub_value + '"]').text();
			sub_text = ' | ' + sub_text;
			jQuery('#candidate_name').val('<?= $firstname . ' ' . $lastname ?>' + ' | ' + main_text + sub_text);
		});
	</script>
<?php }

add_action('wp_footer', 'candidate_name_change');



function return_to_job_thank_you_page()
{
	echo '<a href="#" onclick="window.history.go(-2)" class="back-to-job btn btn-main btn-effect btn-small"> Go back to contract </a>';
}

add_action('woocommerce_thankyou', 'return_to_job_thank_you_page');

/**
 * Change label field
 * 
 */
add_filter('gform_userregistration_login_form', 'change_form', 10, 1);
function change_form($form)
{
	$fields = $form['fields'];
	foreach ($fields as &$field) {
		if ($field->label == 'Username') {
			$field->label = 'Email';
		}
	}
	return $form;
}

/**
 * Auto login and company check
 * The ID depends on the GF form ID.
 * 
 */
add_action('gform_user_registered', 'gw_auto_login', 10, 4);
function gw_auto_login($user_id, $feed, $entry, $password)
{

	if (rgar($entry, '7') === "Employer") {
		$company_name = rgar($entry, '8');
		$company_description = rgar($entry, '9');

		$meta = [
			'_public_submission' => true,
			'_submission_finalized' => true,
		];

		$data = [
			'post_author'    => $user_id,
			'post_title'     => $company_name,
			'post_content'   => $company_description,
			'post_type'      => 'company',
			'comment_status' => 'closed',
			'post_status'    => 'pending',
			'post_password'  => '',
			'post_name'      => sanitize_title($company_name),
			'meta_input'     => $meta
		];
		$company_id = wp_insert_post($data);
		do_action('cariera_company_submitted', $company_id);
	}

	$user = new WP_User($user_id);
	$user_data = [
		'user_login'     => $user->user_login,
		'user_password'  => $password,
		'remember'       => false
	];

	$result = wp_signon($user_data);

	if (!is_wp_error($result)) {
		global $current_user;
		$current_user = $result;
	}
}

/** ---------------------------------------------------------------- 
 * Ajax function to change application status 
 */

function change_status()
{
	ob_start();


		if (isset($_POST['app_status'])) {
			$status = $_POST['app_status'];
		}
		if (isset($_POST['id'])) {
			$app_id = $_POST['id'];
		}

	wp_update_post(array('ID'=>  $app_id,	'post_status' =>  $status));
	if ($status == 'hired') {
		$btn = 'hired';
	} else {
		$btn = '';
	}
	echo $btn;
	wp_die();

}


add_action('wp_ajax_change_status', 'change_status');
add_action('wp_ajax_nopriv_change_status', 'change_status');

// Remove preview option while submitting vehicle form

add_filter('submit_resume_steps', function ($steps) {
	unset($steps['preview']);
	return $steps;
});


add_filter('submit_job_steps', function ($steps) {
	unset($steps['preview']);
	return $steps;
});


add_action('resume_manager_update_resume_data', function ($resume_id) {
	$resume = get_post($resume_id);
	if (in_array($resume->post_status, array('preview', 'expired'), true)) {
		delete_post_meta($resume->ID, '_resume_expires');

		$update_resume                  = array();
		$update_resume['ID']            = $resume->ID;
		$update_resume['post_status']   = get_option('resume_manager_submission_requires_approval') ? 'pending' : 'publish';
		$update_resume['post_date']     = current_time('mysql');
		$update_resume['post_date_gmt'] = current_time('mysql', 1);
		wp_update_post($update_resume);
	}
});

/**
 * Hooks GF email notification.
 * 
 */
add_filter('gform_pre_send_email', function ($email) {
	ob_start();
	get_template_part('/templates/emails/header');
?>
	<tr>
		<td class="details">
			<?= $email['message'] ?>
		</td>
	</tr>
<?php
	get_template_part('/templates/emails/footer');
	$email['message'] = ob_get_clean();
	return $email;
});
