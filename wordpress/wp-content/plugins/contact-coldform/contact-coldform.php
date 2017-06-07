<?php 
/*
	Plugin Name: Contact Coldform
	Plugin URI: https://perishablepress.com/contact-coldform/
	Description: Secure, lightweight and flexible contact form with plenty of options and squeaky clean markup.
	Tags: captcha, contact, contact form, email, form, mail
	Author: Jeff Starr
	Author URI: https://plugin-planet.com/
	Donate link: http://m0n.co/donate
	Contributors: specialk
	Requires at least: 4.1
	Tested up to: 4.7
	Stable tag: 20161114
	Version: 20161114
	Text Domain: contact-coldform
	Domain Path: /languages
	License: GPL v2 or later
*/

if (!function_exists('add_action')) die();



$contact_coldform_wp_vers = '4.1';
$contact_coldform_version = '20161114';
$contact_coldform_plugin  = esc_html__('Contact Coldform', 'contact-coldform');
$contact_coldform_options = get_option('contact_coldform_options');
$contact_coldform_path    = plugin_basename(__FILE__); // 'contact-coldform/contact-coldform.php';
$contact_coldform_homeurl = 'https://perishablepress.com/contact-coldform/';



function coldform_i18n_init() {
	
	load_plugin_textdomain('contact-coldform', false, dirname(plugin_basename(__FILE__)) .'/languages/');
	
}
add_action('plugins_loaded', 'coldform_i18n_init');



function contact_coldform_require_wp_version() {
	
	global $wp_version, $contact_coldform_path, $contact_coldform_plugin, $contact_coldform_wp_vers;
	
	if (version_compare($wp_version, $contact_coldform_wp_vers, '<')) {
		
		if (is_plugin_active($contact_coldform_path)) {
			
			deactivate_plugins($contact_coldform_path);
			
			$msg  = '<strong>'. $contact_coldform_plugin .'</strong> ';
			$msg .= esc_html__('requires WordPress ', 'contact-coldform') . $contact_coldform_wp_vers;
			$msg .= esc_html__(' or higher, and has been deactivated! ', 'contact-coldform');
			$msg .= esc_html__('Please return to the ', 'contact-coldform') . '<a href="' . admin_url() . '">';
			$msg .= esc_html__('WordPress Admin Area', 'contact-coldform') . '</a> ';
			$msg .= esc_html__('to upgrade WordPress and try again.', 'contact-coldform');
			
			wp_die($msg);
			
		}
		
	}
	
}
if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	
	add_action('admin_init', 'contact_coldform_require_wp_version');
	
}



$contact_coldform_name     = isset($_POST['coldform_name'])     ? esc_attr($_POST['coldform_name'])        : '';
$contact_coldform_email    = isset($_POST['coldform_email'])    ? sanitize_email($_POST['coldform_email']) : '';
$contact_coldform_website  = isset($_POST['coldform_website'])  ? esc_url($_POST['coldform_website'])      : '';
$contact_coldform_subject  = isset($_POST['coldform_topic'])    ? esc_attr($_POST['coldform_topic'])       : '';
$contact_coldform_response = isset($_POST['coldform_response']) ? esc_attr($_POST['coldform_response'])    : '';
$contact_coldform_message  = isset($_POST['coldform_message'])  ? esc_textarea($_POST['coldform_message']) : '';

$contact_coldform_strings = array(
	'name'     => '<input name="coldform_name" id="coldform_name" type="text" size="33" maxlength="99" value="'. $contact_coldform_name .'" placeholder="'. esc_attr__('Your name', 'contact-coldform') .'" />', 
	'email'    => '<input name="coldform_email" id="coldform_email" type="text" size="33" maxlength="99" value="'. $contact_coldform_email .'" placeholder="'. esc_attr__('Your email', 'contact-coldform') .'" />', 
	'website'  => '<input name="coldform_website" id="coldform_website" type="text" size="33" maxlength="99" value="'. $contact_coldform_website .'" placeholder="'. esc_attr__('Your website', 'contact-coldform') .'" />', 
	'subject'  => '<input name="coldform_topic" id="coldform_topic" type="text" size="33" maxlength="99" value="'. $contact_coldform_subject .'" placeholder="'. esc_attr__('Subject of email', 'contact-coldform') .'" />', 
	'response' => '<input name="coldform_response" id="coldform_response" type="text" size="33" maxlength="99" value="'. $contact_coldform_response .'" placeholder="'. esc_attr__('Please type the correct response', 'contact-coldform') .'" />', 
	'message'  => '<textarea name="coldform_message" id="coldform_message" cols="33" rows="7" placeholder="'. esc_attr__('Your message', 'contact-coldform') .'">'. $contact_coldform_message .'</textarea>', 
	'verify'   => '<input name="coldform_verify" type="text" size="33" maxlength="99" value="" />', 
	'error'    => '',
);



function contact_coldform_input_filter() {
	
	global $contact_coldform_options, $contact_coldform_strings, $contact_coldform_name, $contact_coldform_email, $contact_coldform_message, $contact_coldform_response;
	
	$options = $contact_coldform_options;
	
	$style = isset($options['coldform_style'])    ? $options['coldform_style']    : '';
	$quest = isset($options['coldform_question']) ? $options['coldform_question'] : '';
	$error = isset($options['coldform_error'])    ? $options['coldform_error']    : '';
	$spam  = isset($options['coldform_spam'])     ? $options['coldform_spam']     : '';
	$trust = isset($options['coldform_trust'])    ? $options['coldform_trust']    : false;
	
	$name     = $contact_coldform_name;
	$email    = $contact_coldform_email;
	$message  = $contact_coldform_message;
	$response = $contact_coldform_response;
	
	$key = isset($_POST['coldform_key']) ? sanitize_text_field($_POST['coldform_key']) : '';
	
	$verify = (!isset($_POST['coldform_verify']) || empty($_POST['coldform_verify'])) ? true : false;
	
	$pass = true;
	
	if (empty($key)) return false;
	
	if (!$verify) { 
		
		$pass = false;
		$notice = esc_html__('Please leave the hidden verification field empty and try again.', 'contact-coldform');
		$contact_coldform_strings['error'] = '<p class="coldform-error">'. $notice .'</p>';
		$contact_coldform_strings['verify'] = '<input name="coldform_verify" type="text" class="coldform-error-input" value="" />';
		
	}
	
	if (contact_coldform_filter_input($name) || contact_coldform_filter_input($email)) {
		
		$pass = false;
		$notice  = esc_html__('Please do not include any of the following in the Name or Email fields: ', 'contact-coldform');
		$notice .= esc_html__('line breaks, &ldquo;mime-version&rdquo;, &ldquo;content-type&rdquo;, &ldquo;cc:&rdquo; &ldquo;to:&rdquo;', 'contact-coldform');
		$contact_coldform_strings['error'] = '<p class="coldform-error">'. $notice .'</p>';
		
	}
	
	if (empty($name)) {
		
		$pass = false;
		$contact_coldform_strings['error'] = $error;
		$contact_coldform_strings['name']  = '<input name="coldform_name" id="coldform_name" type="text" size="33" maxlength="99" value="'. $name .'" '; 
		$contact_coldform_strings['name'] .= 'class="coldform-error-input" '. $style .' placeholder="'. esc_attr__('Your name', 'contact-coldform') .'" />';
		
	}
	
	if (!is_email($email)) {
		
		$pass = false;
		$contact_coldform_strings['error'] = $error;
		$contact_coldform_strings['email']  = '<input name="coldform_email" id="coldform_email" type="text" size="33" maxlength="99" value="'. $email .'" ';
		$contact_coldform_strings['email'] .= 'class="coldform-error-input" '. $style .' placeholder="'. esc_attr__('Your email', 'contact-coldform') .'" />';
		
	}
	
	if (empty($message)) {
		
		$pass = false; 
		$contact_coldform_strings['error'] = $error;
		$contact_coldform_strings['message']  = '<textarea name="coldform_message" id="coldform_message" cols="33" rows="11" class="coldform-error-input" '. $style;
		$contact_coldform_strings['message'] .= ' placeholder="'. esc_attr__('Your message', 'contact-coldform') .'">'. $message .'</textarea>';
		
	}
	
	if ($trust == false) {
		
		$captcha = true;
		
		if (empty($response)) {
			
			$pass = false;
			$captcha = false;
			$contact_coldform_strings['error'] = $error;
			
		}
		
		if (!contact_coldform_spam_question($response)) {
			
			$pass = false;
			$captcha = false;
			$contact_coldform_strings['error'] = $spam;
			
		}
		
		if (!$captcha) {
			
			$contact_coldform_strings['response']  = '<input name="coldform_response" id="coldform_response" type="text" size="33" maxlength="99" ';
			$contact_coldform_strings['response'] .= 'value="'. $response .'" class="coldform-error-input" '. $style .' placeholder="'. $quest .'" />';
			
		}
		
	}
	
	if ($pass == true) return true;
	
	return false;
	
}



function contact_coldform_filter_input($input) {
	
	$maliciousness = false;
	$denied_inputs = array("\r", "\n", "mime-version", "content-type", "cc:", "to:");
	
	foreach ($denied_inputs as $denied_input) {
		
		if (strpos(strtolower($input), strtolower($denied_input)) !== false) {
			
			$maliciousness = true;
			break;
			
		}
		
	}
	
	return $maliciousness;
	
}



function contact_coldform_spam_question($input) {
	
	global $contact_coldform_options;
	
	$response = $contact_coldform_options['coldform_response'];
	
	$response = stripslashes(trim($response));
	
	if ($contact_coldform_options['coldform_casing'] == true) {
		
		return (strtoupper($input) == strtoupper($response));
		
	} else {
		
		return ($input == $response);
		
	}
	
}



function contact_coldform_get_ip_address() {
	
	if (isset($_SERVER)) {
		
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
			
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
			
		}
		
	} else {
		
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
			
		} elseif (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
			
		} else {
			$ip_address = getenv('REMOTE_ADDR');
			
		}
		
	}
	
	return $ip_address;
	
}



function contact_coldform_register_style() {
	
	global $contact_coldform_options, $contact_coldform_version;
	
	$coldform_coldskin = isset($contact_coldform_options['coldform_coldskin']) ? $contact_coldform_options['coldform_coldskin'] : null;
	$enable_styles     = isset($contact_coldform_options['coldform_styles'])   ? $contact_coldform_options['coldform_styles']   : null;
	$coldform_url      = isset($contact_coldform_options['coldform_url'])      ? $contact_coldform_options['coldform_url']      : null;
	
	$protocol     = is_ssl() ? 'https://' : 'http://';
	$coldform_url = esc_url_raw(trim($coldform_url));
	$current_url  = esc_url_raw($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	
	if     ($coldform_coldskin == 'coldskin_default') $coldskin = 'default.css';
	elseif ($coldform_coldskin == 'coldskin_classic') $coldskin = 'classic.css';
	elseif ($coldform_coldskin == 'coldskin_dark')    $coldskin = 'dark.css';
	
	if ($enable_styles == true) {
		
		if (!empty($coldform_url)) {
			
			if (strpos($current_url, $coldform_url) !== false) {
				
				wp_enqueue_style('coldform', plugins_url() .'/contact-coldform/coldskins/coldskin-'. $coldskin, array(), $contact_coldform_version, 'all');
				
			}
			
		} else {
			
			wp_enqueue_style('coldform', plugins_url() .'/contact-coldform/coldskins/coldskin-'. $coldskin, array(), $contact_coldform_version, 'all');
			
		}
		
	}
	
}
add_action('wp_enqueue_scripts', 'contact_coldform_register_style');



function contact_coldform_shortcode() {
	
	if (contact_coldform_input_filter()) {
		
		return contact_coldform();
		
	}
	
	return contact_coldform_display_form();
	
}
add_shortcode('coldform','contact_coldform_shortcode');
add_shortcode('contact_coldform','contact_coldform_shortcode');



function contact_coldform_public() {
	
	if (contact_coldform_input_filter()) {
		
		echo contact_coldform();
		
	} else {
		
		echo contact_coldform_display_form();
		
	}
	
}



function contact_coldform_display_form() {
	
	global $contact_coldform_options, $contact_coldform_strings;
	
	$options = $contact_coldform_options;
	$strings = $contact_coldform_strings;
	
	$styles = !empty($options['coldform_custom']) ? '<style type="text/css">'. $options['coldform_custom'] .'</style>' : '';
	
	$website = '';
	$captcha = '';
	$carbon  = '';
	
	if ($options['display_website'] == true) {
		
		$website = '<fieldset class="coldform-website">
					<label for="coldform_website">'. $options['coldform_sitetext'] .'</label>
					'. $strings['website'] .'
				</fieldset>';
	}
	
	if ($options['display_captcha'] && $options['coldform_trust'] == false) {
		
		$captcha = '<fieldset class="coldform-response">
					<label for="coldform_response">'. $options['coldform_question'] .'</label>
					'. $strings['response'] .'
				</fieldset>';
		
	}
	
	if ($options['coldform_carbon'] == true) {
		
		$carbon = '<fieldset class="coldform-carbon">
					<input name="coldform_carbon" id="coldform_carbon" type="checkbox" value="1" checked="checked" /> 
					<label for="coldform_carbon">'. $options['coldform_copytext'] .'</label>
				</fieldset>';
	}
	
	$coldform = (
		$strings['error'] .'
		<!-- Contact Coldform @ https://perishablepress.com/contact-coldform/ -->
		
		<div id="coldform">
			<form action="'. get_permalink() .'" method="post">
				<legend title="'. esc_attr__('Note: text only, no markup.', 'contact-coldform') .'">'. $options['coldform_welcome'] .'</legend>
				<fieldset class="coldform-name">
					<label for="coldform_name">'. $options['coldform_nametext'] .'</label>
					'. $strings['name'] .'
				</fieldset>
				<fieldset class="coldform-email">
					<label for="coldform_email">'. $options['coldform_mailtext'] .'</label>
					'. $strings['email'] .'
				</fieldset>
				'. $website .'
				<fieldset class="coldform_topic">
					<label for="coldform_topic">'. $options['coldform_subjtext'] .'</label>
					'. $strings['subject'] .'
				</fieldset>
				'. $captcha .'
				<fieldset class="coldform-message">
					<label for="coldform_message">'. $options['coldform_messtext'] .'</label>
					'. $strings['message'] .'
				</fieldset>
				<fieldset id="coldform_verify" style="display:none;">
					<label for="coldform_verify">'. esc_html__('Human verification: leave this field empty.', 'contact-coldform') .'</label>
					'. $strings['verify'] .'
				</fieldset>
				'. $carbon .'
				<div class="coldform-submit">
					<input name="coldform_submit" id="coldform_submit" type="submit" value="'. esc_attr__('Send it!', 'contact-coldform') .'" />
					<input name="coldform_key" type="hidden" value="process" />
				</div>
			</form>
		</div>
		'. $styles .'
		<script type="text/javascript">(function(){var e = document.getElementById("coldform_verify");e.parentNode.removeChild(e);})();</script>
		<div class="clear">&nbsp;</div>
		');
	
	return $coldform;
	
}



function contact_coldform() {
	
	global $contact_coldform_options;
	
	$options = $contact_coldform_options;
	
	$recipient = $options['coldform_email'];
	$recipname = $options['coldform_name'];
	$recipsite = $options['coldform_website'];
	$success   = $options['coldform_success'];
	$thanks    = $options['coldform_thanks'];
	$offset    = $options['coldform_offset'];
	$subject   = $options['coldform_subject'];
	$prefix    = $options['coldform_prefix'];
	$custom    = $options['coldform_custom'];
	
	$date    = date('l, F jS, Y @ g:i a', time() + $offset * 60 * 60);
	
	$topic   = (isset($_POST['coldform_topic']) && !empty($_POST['coldform_topic'])) ? stripslashes(strip_tags(trim($_POST['coldform_topic']))) : $subject;
	
	$name    = isset($_POST['coldform_name']) ? stripslashes(strip_tags(trim($_POST['coldform_name']))) : '';
	
	$message = isset($_POST['coldform_message']) ? stripslashes(trim($_POST['coldform_message'])) : '';
	
	$site    = isset($_POST['coldform_website']) ? esc_url($_POST['coldform_website']) : '';
	
	$email   = isset($_POST['coldform_email']) ? sanitize_email($_POST['coldform_email']) : '';
	
	$copy    = isset($_POST['coldform_carbon']) ? sanitize_text_field($_POST['coldform_carbon']) : '';
	
	$agent   = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';
	
	$form    = isset($_SERVER['HTTP_REFERER']) ? sanitize_text_field($_SERVER['HTTP_REFERER']) : '';
	
	$host    = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(gethostbyaddr($_SERVER['REMOTE_ADDR'])) : '';
	
	$ip      = sanitize_text_field(contact_coldform_get_ip_address());
	
	$website = !empty($site) ? $site : esc_html__('No website specified.', 'contact-coldform');
	
	$carbon  = !empty($copy) ? esc_html__('Copy sent to sender.', 'contact-coldform') : esc_html__('No carbon copy sent.', 'contact-coldform');
	
	$style   = !empty($custom) ? '<style type="text/css">'. $custom .'</style>' : '';
	
	$topic_display = $topic;
	
	$topic_send = $prefix . $topic;
	
	$message_display = htmlentities($message);
	
	$message_send = "Hello $recipname,

You are being contacted via $recipsite:

Name:     $name
Email:    $email
Carbon:   $carbon
Website:  $website
Subject:  $topic_send
Message:

$message

-----------------------

Additional Information:

IP:     $ip
Site:   $recipsite
URL:    $form
Time:   $date
Host:   $host
Agent:  $agent
Whois:  http://whois.arin.net/rest/net/NET-74-82-224-0-1/pft?s=$ip

";
	
	$headers  = 'X-Mailer: Contact Coldform'. "\n";
	$headers .= 'From: '. $name .' <'. $email .'>'. "\n";
	$headers .= 'Reply-To: '. $name .' <'. $email .'>'. "\n";
	$headers .= 'Content-Type: text/plain; charset='. get_option('blog_charset', 'UTF-8') . "\n";
	
	wp_mail($recipient, $topic_send, $message_send, $headers);
	
	if ($copy == '1') wp_mail($email, $topic_send, $message_send, $headers);
	
	$results = '<div id="coldform_thanks">'. $success . $thanks . 
'<pre><code>Date:      ' . $date . '
Name:      ' . $name             . '
Email:     ' . $email            . '
Carbon:    ' . $carbon           . '
Website:   ' . $website          . '
Subject:   ' . $topic_display    . '
Message:   

' . $message_display .'</code></pre>
<p class="coldform-reset">[ <a href="'. $form .'">'. esc_html__('Click here to reset the form.', 'contact-coldform') .'</a> ]</p>
</div>'. $style;
	
	return $results;
	
}



function contact_coldform_plugin_action_links($links, $file) {
	
	global $contact_coldform_path;
	
	if ($file == $contact_coldform_path) {
		
		$link  = '<a href="'. get_admin_url() .'options-general.php?page='. $contact_coldform_path .'">';
		$link .= esc_html__('Settings', 'contact-coldform') .'</a>';
		
		array_unshift($links, $link);
		
	}
	
	return $links;
	
}
add_filter ('plugin_action_links', 'contact_coldform_plugin_action_links', 10, 2);



function add_coldform_links($links, $file) {
	
	global $contact_coldform_path;
	
	if ($file == $contact_coldform_path) {
		
		$href  = 'https://wordpress.org/support/plugin/contact-coldform/reviews/?rate=5#new-post';
		$title = esc_attr__('Give Contact Coldform a 5-star rating at WordPress.org', 'contact-coldform');
		$text  = esc_html__('Rate this plugin', 'contact-coldform');
		
		$links[] = '<a target="_blank" href="'. $href .'" title="'. $title .'">'. $text .'&nbsp;&raquo;</a>';
		
	}
	
	return $links;
	
}
add_filter('plugin_row_meta', 'add_coldform_links', 10, 2);



function contact_coldform_delete_plugin_options() {
	
	delete_option('contact_coldform_options');
	
}
if ($contact_coldform_options['default_options'] == 1) {
	
	register_uninstall_hook (__FILE__, 'contact_coldform_delete_plugin_options');
	
}

function contact_coldform_add_defaults() {
	
	$user_info = get_userdata(1);
	
	$admin_name = $user_info->user_login;
	
	if (!$admin_name) $admin_name = 'Awesome Person';
	
	$site_title = get_bloginfo('name');
	$admin_mail = get_bloginfo('admin_email');
	$tmp        = get_option('contact_coldform_options');
	
	if (($tmp['default_options'] == '1') || (!is_array($tmp))) {
		
		$arr = array(
			
			// General
			'default_options'   => 0,
			'coldform_email'    => $admin_mail,
			'coldform_name'     => $admin_name,
			'coldform_website'  => $site_title,
			'coldform_subject'  => __('Message sent from your contact form', 'contact-coldform'),
			'coldform_prefix'   => esc_html__('Contact Coldform: ', 'contact-coldform'),
			'coldform_question' => '1 + 1 =',
			'coldform_response' => '2',
			'coldform_casing'   => false,
			'display_captcha'   => true,
			'coldform_trust'    => false,
			'coldform_carbon'   => false,
			'display_website'   => true,
			'coldform_offset'   => '0',
			
			// Captions
			'coldform_nametext' => esc_html__('Name (Required)', 'contact-coldform'),
			'coldform_mailtext' => esc_html__('Email (Required)', 'contact-coldform'),
			'coldform_sitetext' => esc_html__('Website (Optional)', 'contact-coldform'),
			'coldform_subjtext' => esc_html__('Subject (Optional)', 'contact-coldform'),
			'coldform_messtext' => esc_html__('Message (Required)', 'contact-coldform'),
			'coldform_copytext' => esc_html__('Carbon Copy?', 'contact-coldform'),
			
			// Success/Error
			'coldform_welcome'  => '<strong>'. esc_html__('Hello!', 'contact-coldform') .'</strong> '. esc_html__('Please use this contact form to send us an email.', 'contact-coldform'),
			'coldform_success'  => '<p id="coldform_success">'. esc_html__('Success! Your message has been sent.', 'contact-coldform') .'</p>',
			'coldform_thanks'   => '<p class="coldform-thanks"><span>'. esc_html__('Thanks for contacting me.', 'contact-coldform') .'</span> '. esc_html__('The following information has been sent via email:', 'contact-coldform') .'</p>',
			'coldform_spam'     => '<p id="coldform_spam" class="coldform-error">'. esc_html__('Incorrect response for challenge question. Please try again.', 'contact-coldform') .'</p>',
			'coldform_error'    => '<p id="coldform_error" class="coldform-error">'. esc_html__('Please complete the required fields.', 'contact-coldform') .'</p>',
			'coldform_style'    => 'style="border: 3px solid #CC0000;"',
			
			// Appearance
			
			'coldform_coldskin' => 'coldskin_default',
			'coldform_styles'   => true,
			'coldform_custom'   => '',
			'coldform_url'      => '',
			
		);
		
		update_option('contact_coldform_options', $arr);
		
	}
	
}
register_activation_hook (__FILE__, 'contact_coldform_add_defaults');



function contact_coldform_validate_options($input) {
	
	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);
	
	// General
	$input['coldform_email']    = esc_attr($input['coldform_email']);
	$input['coldform_name']     = esc_attr($input['coldform_name']);
	$input['coldform_website']  = esc_attr($input['coldform_website']);
	$input['coldform_subject']  = esc_attr($input['coldform_subject']);
	$input['coldform_prefix']   = esc_attr($input['coldform_prefix']);
	$input['coldform_question'] = esc_attr($input['coldform_question']);
	$input['coldform_response'] = esc_attr($input['coldform_response']);
	
	if (!isset($input['coldform_casing'])) $input['coldform_casing'] = null;
	$input['coldform_casing'] = ($input['coldform_casing'] == 1 ? 1 : 0);
	
	if (!isset($input['display_captcha'])) $input['display_captcha'] = null;
	$input['display_captcha'] = ($input['display_captcha'] == 1 ? 1 : 0);
	
	if (!isset($input['coldform_trust'])) $input['coldform_trust'] = null;
	$input['coldform_trust'] = ($input['coldform_trust'] == 1 ? 1 : 0);
	
	if (!isset($input['coldform_carbon'])) $input['coldform_carbon'] = null;
	$input['coldform_carbon'] = ($input['coldform_carbon'] == 1 ? 1 : 0);
	
	if (!isset($input['display_website'])) $input['display_website'] = null;
	$input['display_website'] = ($input['display_website'] == 1 ? 1 : 0);
	
	$input['coldform_offset'] = esc_attr($input['coldform_offset']);
	
	// Captions
	$input['coldform_nametext'] = esc_attr($input['coldform_nametext']);
	$input['coldform_mailtext'] = esc_attr($input['coldform_mailtext']);
	$input['coldform_sitetext'] = esc_attr($input['coldform_sitetext']);
	$input['coldform_subjtext'] = esc_attr($input['coldform_subjtext']);
	$input['coldform_messtext'] = esc_attr($input['coldform_messtext']);
	$input['coldform_copytext'] = esc_attr($input['coldform_copytext']);
	
	// Success/Error
	$input['coldform_welcome'] = wp_kses_post($input['coldform_welcome']);
	$input['coldform_success'] = wp_kses_post($input['coldform_success']);
	$input['coldform_thanks']  = wp_kses_post($input['coldform_thanks']);
	$input['coldform_spam']    = wp_kses_post($input['coldform_spam']);
	$input['coldform_error']   = wp_kses_post($input['coldform_error']);
	$input['coldform_style']   = wp_kses_post($input['coldform_style']);
	
	// Appearance
	$coldform_coldskins = contact_coldform_coldskins();
	if (!isset($input['coldform_coldskin'])) $input['coldform_coldskin'] = null;
	if (!array_key_exists($input['coldform_coldskin'], $coldform_coldskins)) $input['coldform_coldskin'] = null;
	
	if (!isset($input['coldform_styles'])) $input['coldform_styles'] = null;
	$input['coldform_styles'] = ($input['coldform_styles'] == 1 ? 1 : 0);
	
	$input['coldform_custom'] = sanitize_text_field($input['coldform_custom']);
	$input['coldform_url']    = esc_url($input['coldform_url']);
	
	return $input;
	
}


function contact_coldform_coldskins() {
	
	$coldskins = array(
		
		'coldskin_default' => array(
			'value' => 'coldskin_default',
			'label' => esc_attr__('Default styles', 'contact-coldform'),
		),
		'coldskin_classic' => array(
			'value' => 'coldskin_classic',
			'label' => esc_attr__('Classic styles', 'contact-coldform'),
		),
		'coldskin_dark' => array(
			'value' => 'coldskin_dark',
			'label' => esc_attr__('Dark styles', 'contact-coldform'),
		),
	);
	
	return $coldskins;
	
}



function contact_coldform_init() {
	
	register_setting('contact_coldform_plugin_options', 'contact_coldform_options', 'contact_coldform_validate_options');
	
}
add_action ('admin_init', 'contact_coldform_init');



function contact_coldform_add_options_page() {
	
	global $contact_coldform_plugin;
	
	add_options_page($contact_coldform_plugin, $contact_coldform_plugin, 'manage_options', __FILE__, 'contact_coldform_render_form');
	
}
add_action ('admin_menu', 'contact_coldform_add_options_page');



function contact_coldform_render_form() {
	
	global $contact_coldform_plugin, $contact_coldform_options, $contact_coldform_path, $contact_coldform_homeurl, $contact_coldform_version; 
	
	$options = $contact_coldform_options;
	
	$offset = $options['coldform_offset'];
	
	$coldform_coldskins = contact_coldform_coldskins();
	
	?>
	
	<style type="text/css">
		.mm-panel-overview { 
			padding: 0 20px 0 115px; 
			background-image: url(<?php echo plugins_url(); ?>/contact-coldform/contact-coldform.png); 
			background-repeat: no-repeat; background-position: 15px 0; background-size: 100px 100px; 
			}
		
		#mm-plugin-options h1 small { font-size: 60%; color: #c7c7c7; }
		#mm-plugin-options h2 { margin: 0; padding: 12px 0 12px 15px; font-size: 16px; cursor: pointer; }
		#mm-plugin-options h3 { margin: 20px 15px; font-size: 14px; }
		
		#mm-plugin-options p { margin-left: 15px; }
		#mm-plugin-options ul { margin: 15px 15px 25px 40px; line-height: 16px; }
		#mm-plugin-options li { margin: 8px 0; list-style-type: disc; }
		#mm-plugin-options abbr[title] { cursor: help !important; border-bottom: 1px dotted #dfdfdf !important; text-decoration: none !important; }
		#mm-plugin-options textarea { width: 80%; }
		
		.mm-table-wrap { margin: 15px; }
		.mm-table-wrap td { padding: 5px 10px; vertical-align: middle; }
		.mm-table-wrap .mm-table { padding: 10px 0; }
		.mm-table-wrap .widefat th { padding: 10px 15px; vertical-align: middle; }
		.mm-table-wrap .widefat td { padding: 10px; vertical-align: middle; }
		
		.mm-item-caption { margin: 1px 0 0 3px; font-size: 11px; color: #777; line-height: 17px; }
		.mm-item-caption code { font-size: 12px; }
		.mm-radio-inputs { margin: 5px 0; }
		.mm-code { background-color: #fafae0; color: #333; font-size: 14px; }
		
		#setting-error-settings_updated { margin: 10px 0; }
		#setting-error-settings_updated p { margin: 5px; }
		#mm-plugin-options .button-primary { margin: 0 0 15px 15px; }
		
		#mm-panel-toggle { margin: 5px 0; }
		#mm-credit-info { margin-top: -5px; }
		#mm-iframe-wrap { width: 100%; height: 250px; overflow: hidden; }
		#mm-iframe-wrap iframe { width: 100%; height: 100%; overflow: hidden; margin: 0; padding: 0; }
	</style>
	
	<div id="mm-plugin-options" class="wrap">
		<h1><?php echo $contact_coldform_plugin; ?> <small><?php echo 'v'. $contact_coldform_version; ?></small></h1>
		<div id="mm-panel-toggle">
			<a href="<?php get_admin_url() .'options-general.php?page='. $contact_coldform_path; ?>"><?php esc_html_e('Toggle all panels', 'contact-coldform'); ?></a>
		</div>
		
		<form method="post" action="options.php">
			<?php settings_fields('contact_coldform_plugin_options'); ?>
			
			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable">
					<div id="mm-panel-overview" class="postbox">
						<h2><?php esc_html_e('Overview', 'contact-coldform'); ?></h2>
						<div class="toggle">
							<div class="mm-panel-overview">
								<p>
									<strong><?php echo $contact_coldform_plugin; ?></strong> <?php esc_html_e(' delivers a lightweight contact form with super clean markup and no JavaScript required.', 'contact-coldform'); ?>
									<?php esc_html_e('Use the shortcode to display the Coldform on any post or page. Use the template tag to display the Coldform anywhere in your theme template.', 'contact-coldform'); ?>
								</p>
								<ul>
									<li>
										<?php esc_html_e('To get started, check out the', 'contact-coldform'); ?> 
										<a id="mm-panel-secondary-link" href="#mm-panel-secondary"><?php esc_html_e('Shortcodes &amp; Template Tags', 'contact-coldform'); ?></a>
									</li>
									<li>
										<?php esc_html_e('For information and support, visit the', 'contact-coldform'); ?> 
										<a target="_blank" href="https://wordpress.org/plugins/contact-coldform/"><?php esc_html_e('Coldform Homepage', 'contact-coldform'); ?>&nbsp;&raquo;</a>
									</li>
									<li><?php esc_html_e('If you like this plugin, please', 'contact-coldform'); ?> 
										<a target="_blank" href="https://wordpress.org/support/plugin/contact-coldform/reviews/?rate=5#new-post" title="<?php esc_attr_e('Thank you for your support!', 'contact-coldform'); ?>">
											<?php esc_html_e('give it a 5-star rating', 'contact-coldform'); ?>&nbsp;&raquo;
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div id="mm-panel-primary" class="postbox">
						<h2><?php esc_html_e('Coldform Options', 'contact-coldform'); ?></h2>
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							<p><?php esc_html_e('Configure and customize Contact Coldform.', 'contact-coldform'); ?></p>
							<h3><?php esc_html_e('General options', 'contact-coldform'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_email]"><?php esc_html_e('Your Email', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_email]" value="<?php echo $options['coldform_email']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Where shall Coldform send your messages?', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_name]"><?php esc_html_e('Your Name', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_name]" value="<?php echo $options['coldform_name']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('To whom shall Coldform address your messages?', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_website]"><?php esc_html_e('Your Website', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_website]" value="<?php echo $options['coldform_website']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('What is the name of your blog or website?', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_subject]"><?php esc_html_e('Default Subject', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_subject]" value="<?php echo $options['coldform_subject']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This will be the subject of the email if none is specified', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_prefix]"><?php esc_html_e('Subject Prefix', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_prefix]" value="<?php echo $options['coldform_prefix']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This will be prepended to any subject specified by the sender', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_offset]"><?php esc_html_e('Time Offset', 'contact-coldform'); ?></label></th>
										<td>
											<input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_offset]" value="<?php echo $options['coldform_offset']; ?>" />
											<div class="mm-item-caption">
												<?php esc_html_e('Please specify any time offset here. For example, +7 or -7. If no offset or unsure, enter 0 (zero).', 'contact-coldform'); ?><br />
												<?php esc_html_e('Current Coldform time:', 'contact-coldform'); ?> <?php echo date("l, F jS, Y @ g:i a", time() + $offset * 60 * 60); ?>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[display_website]"><?php esc_html_e('Display Website Field', 'contact-coldform'); ?></label></th>
										<td><input type="checkbox" name="contact_coldform_options[display_website]" value="1" <?php if (isset($options['display_website'])) { checked('1', $options['display_website']); } ?> /> 
										<?php esc_html_e('Check this box if you want to display the &ldquo;Website&rdquo; field in the contact form', 'contact-coldform'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_carbon]"><?php esc_html_e('Carbon Copies', 'contact-coldform'); ?></label></th>
										<td><input type="checkbox" name="contact_coldform_options[coldform_carbon]" value="1" <?php if (isset($options['coldform_carbon'])) { checked('1', $options['coldform_carbon']); } ?> /> 
										<?php esc_html_e('Check this box if you want to enable users to receive carbon copies', 'contact-coldform'); ?></td>
									</tr>
								</table>
							</div>
							<h3><?php esc_html_e('Antispam challenge', 'contact-coldform'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_question]"><?php esc_html_e('Challenge Question', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_question]" value="<?php echo $options['coldform_question']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This question must be answered correctly before mail is sent', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_response]"><?php esc_html_e('Challenge Response', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_response]" value="<?php echo $options['coldform_response']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('The only correct answer to the challenge question', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_casing]"><?php esc_html_e('Case Sensitivity', 'contact-coldform'); ?></label></th>
										<td><input type="checkbox" name="contact_coldform_options[coldform_casing]" value="1" <?php if (isset($options['coldform_casing'])) { checked('1', $options['coldform_casing']); } ?> /> 
										<?php esc_html_e('Make the challenge response case-insensitive', 'contact-coldform'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[display_captcha]"><?php esc_html_e('Display Captcha', 'contact-coldform'); ?></label></th>
										<td><input type="checkbox" name="contact_coldform_options[display_captcha]" value="1" <?php if (isset($options['display_captcha'])) { checked('1', $options['display_captcha']); } ?> /> 
										<?php esc_html_e('Enable the challenge question', 'contact-coldform'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_trust]"><?php esc_html_e('Trust Registered Users', 'contact-coldform'); ?></label></th>
										<td><input type="checkbox" name="contact_coldform_options[coldform_trust]" value="1" <?php if (isset($options['coldform_trust'])) { checked('1', $options['coldform_trust']); } ?> /> 
										<?php esc_html_e('Disable the challenge question for logged-in users', 'contact-coldform'); ?></td>
									</tr>
								</table>
							</div>
							<h3><?php esc_html_e('Coldform captions', 'contact-coldform'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_nametext]"><?php esc_html_e('Caption for Name Field', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_nametext]" value="<?php echo $options['coldform_nametext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This is the caption that corresponds with the Name field', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_mailtext]"><?php esc_html_e('Caption for Email Field', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_mailtext]" value="<?php echo $options['coldform_mailtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This is the caption that corresponds with the Email field', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_sitetext]"><?php esc_html_e('Caption for Website Field', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_sitetext]" value="<?php echo $options['coldform_sitetext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This is the caption that corresponds with the Website field', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_subjtext]"><?php esc_html_e('Caption for Subject Field', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_subjtext]" value="<?php echo $options['coldform_subjtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This is the caption that corresponds with the Subject field', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_messtext]"><?php esc_html_e('Caption for Message Field', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_messtext]" value="<?php echo $options['coldform_messtext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This is the caption that corresponds with the Message field', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_copytext]"><?php esc_html_e('Caption for Carbon Copy', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_copytext]" value="<?php echo $options['coldform_copytext']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('This caption corresponds with the Carbon Copy checkbox', 'contact-coldform'); ?></div></td>
									</tr>
								</table>
							</div>
							<h3><?php esc_html_e('Success &amp; error messages', 'contact-coldform'); ?></h3>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_welcome]"><?php esc_html_e('Welcome Message', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea code" rows="3" cols="50" name="contact_coldform_options[coldform_welcome]"><?php echo esc_textarea($options['coldform_welcome']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('This text/markup will appear before the Coldform, in the', 'contact-coldform'); ?> <code>&lt;legend&gt;</code> <?php esc_html_e('tag', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_success]"><?php esc_html_e('Success Message', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea code" rows="3" cols="50" name="contact_coldform_options[coldform_success]"><?php echo esc_textarea($options['coldform_success']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('When the form is sucessfully submitted, this success message will be displayed to the sender', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_thanks]"><?php esc_html_e('Thank You Message', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea code" rows="3" cols="50" name="contact_coldform_options[coldform_thanks]"><?php echo esc_textarea($options['coldform_thanks']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('When the form is sucessfully submitted, this thank-you message will be displayed to the sender', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_spam]"><?php esc_html_e('Incorrect Response', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea code" rows="3" cols="50" name="contact_coldform_options[coldform_spam]"><?php echo esc_textarea($options['coldform_spam']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('When the challenge question is answered incorrectly, this message will be displayed', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_error]"><?php esc_html_e('Error Message', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea code" rows="3" cols="50" name="contact_coldform_options[coldform_error]"><?php echo esc_textarea($options['coldform_error']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('If the user skips a required field, this message will be displayed', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_style]"><?php esc_html_e('Error Fields', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea code" rows="3" cols="50" name="contact_coldform_options[coldform_style]"><?php echo esc_textarea($options['coldform_style']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Here you may specify the default CSS for error fields, or add other attributes', 'contact-coldform'); ?></div></td>
									</tr>
								</table>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'contact-coldform'); ?>" />
						</div>
					</div>
					<div id="mm-panel-tertiary" class="postbox">
						<h2><?php esc_html_e('Appearance &amp; Styles', 'contact-coldform'); ?></h2>
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							<h3><?php esc_html_e('Coldskin', 'contact-coldform'); ?></h3>
							<p>
								<?php esc_html_e('Default Coldskin styles are enabled by default. Here you may choose different Coldskin and/or add your own custom CSS styles. Note: for a complete list of CSS hooks for the Coldform, visit:', 'contact-coldform'); ?> 
								<a href="http://m0n.co/b" target="_blank">http://m0n.co/b</a>
							</p>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_coldskin]"><?php esc_html_e('Choose a Coldskin', 'contact-coldform'); ?></label></th>
										<td>
											<?php if (!isset($checked)) $checked = '';
												
												foreach ($coldform_coldskins as $coldskin) :
													
													if (!empty($options['coldform_coldskin'])) {
														
														$checked = ($options['coldform_coldskin'] == $coldskin['value']) ? 'checked="checked"' : '';
														
													} ?>
													
													<div class="mm-radio-inputs">
														<input type="radio" name="contact_coldform_options[coldform_coldskin]" value="<?php echo esc_attr($coldskin['value']); ?>" <?php echo $checked; ?> /> 
														<?php echo $coldskin['label']; ?>
													</div>
													
											<?php endforeach; ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_styles]"><?php esc_html_e('Enable Coldskin?', 'contact-coldform'); ?></label></th>
										<td><input name="contact_coldform_options[coldform_styles]" type="checkbox" value="1" <?php if (isset($options['coldform_styles'])) checked('1', $options['coldform_styles']); ?> /> 
										<?php esc_html_e('Here you may enable/disable the Coldskin selected above', 'contact-coldform'); ?></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_custom]"><?php esc_html_e('Custom Styles', 'contact-coldform'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="contact_coldform_options[coldform_custom]"><?php echo esc_textarea($options['coldform_custom']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Any additional CSS to style the Coldform, for example:', 'contact-coldform'); ?>
										<code>#coldform { margin: 10px; }</code> <?php esc_html_e('(do not include', 'contact-coldform'); ?> <code>&lt;style&gt;</code> <?php esc_html_e('tags)', 'contact-coldform'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="contact_coldform_options[coldform_url]"><?php esc_html_e('Coldform URL', 'contact-coldform'); ?></label></th>
										<td><input type="text" size="50" maxlength="200" name="contact_coldform_options[coldform_url]" value="<?php echo $options['coldform_url']; ?>" />
										<div class="mm-item-caption"><?php esc_html_e('By default, Coldform includes the above styles on every page. To include styles only on a specific page, enter its URL here.', 'contact-coldform'); ?></div></td>
									</tr>
								</table>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'contact-coldform'); ?>" />
						</div>
					</div>
					<div id="mm-panel-secondary" class="postbox">
						<h2><?php esc_html_e('Shortcodes &amp; Template Tags', 'contact-coldform'); ?></h2>
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							<h3><?php esc_html_e('Shortcode', 'contact-coldform'); ?></h3>
							<p><?php esc_html_e('Use this shortcode to display the Coldform on a post or page:', 'contact-coldform'); ?></p>
							<p><code class="mm-code">[coldform]</code></p>
							<h3><?php esc_html_e('Template tag', 'contact-coldform'); ?></h3>
							<p><?php esc_html_e('Use this template tag to display the Coldform anywhere in your theme template:', 'contact-coldform'); ?></p>
							<p><code class="mm-code">&lt;?php if (function_exists('contact_coldform_public')) contact_coldform_public(); ?&gt;</code></p>
						</div>
					</div>
					<div id="mm-restore-settings" class="postbox">
						<h2><?php esc_html_e('Restore Default Options', 'contact-coldform'); ?></h2>
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							<p>
								<input name="contact_coldform_options[default_options]" type="checkbox" value="1" id="mm_restore_defaults" <?php if (isset($options['default_options'])) { checked('1', $options['default_options']); } ?> /> 
								<label class="description" for="contact_coldform_options[default_options]"><?php esc_html_e('Restore default options upon plugin deactivation/reactivation.', 'contact-coldform'); ?></label>
							</p>
							<p>
								<small>
									<strong><?php esc_html_e('Tip:', 'contact-coldform'); ?></strong> 
									<?php esc_html_e('leave this option unchecked to remember your settings. Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'contact-coldform'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'contact-coldform'); ?>" />
						</div>
					</div>
					<div id="mm-panel-current" class="postbox">
						<h2><?php esc_html_e('Show Support', 'contact-coldform'); ?></h2>
						<div class="toggle">
							<div id="mm-iframe-wrap">
								<iframe src="https://perishablepress.com/current/index-cc.html"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="mm-credit-info">
				<a target="_blank" href="<?php echo $contact_coldform_homeurl; ?>" title="<?php echo $contact_coldform_plugin; ?> Homepage"><?php echo $contact_coldform_plugin; ?></a> by 
				<a target="_blank" href="https://twitter.com/perishable" title="Jeff Starr on Twitter">Jeff Starr</a> @ 
				<a target="_blank" href="http://monzillamedia.com/" title="Obsessive Web Design &amp; Development">Monzilla Media</a>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			// toggle panels
			jQuery('.default-hidden').hide();
			jQuery('#mm-panel-toggle a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('h2').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('#mm-panel-primary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-primary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-panel-secondary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-secondary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-panel-tertiary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-tertiary .toggle').slideToggle(300);
				return true;
			});
			// prevent accidents
			if(!jQuery("#mm_restore_defaults").is(":checked")){
				jQuery('#mm_restore_defaults').click(function(event){
					var r = confirm("<?php _e('Are you sure you want to restore all default options? (this action cannot be undone)', 'contact-coldform'); ?>");
					if (r == true){  
						jQuery("#mm_restore_defaults").attr('checked', true);
					} else {
						jQuery("#mm_restore_defaults").attr('checked', false);
					}
				});
			}
		});
	</script>
	
<?php }
