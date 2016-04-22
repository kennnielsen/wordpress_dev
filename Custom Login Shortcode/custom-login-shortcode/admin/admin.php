<?php 

// Meaning of abbreviations:
// clsc = Custom login shortcode

// Runs when plugin is activated
register_activation_hook( PLUGIN_MAIN_FILE, 'clsc_install');

// Create new database fields
function clsc_install() {
	$clsc_options = array(

		'Login_link' 		=> 'log-in/',
		'Login_string' 		=> 'Log in',
		'Login_class'		=> '', // Default is empty to inherit theme styles
		'Logout_link'		=> wp_logout_url( home_url()),
		'Logout_string'		=> 'Log out',
		'Logout_class'		=> '', // Default is empty to inherit theme styles
		'Account_link' 		=> 'my-account/',
		'Account_string'	=> 'My Account',
		'Account_class'		=> '' // Default is empty to inherit theme styles

	);
	add_option('clsc_options_array', $clsc_options, '', 'yes');
}


function add_clsc_option_admin_page() {

	// Create custom admin option page
	add_options_page(
		'Custom Login', 			// The text to be displayed in the title tag
		'Custom Login', 			// The text to be used for the menu
		'administrator', 			// The capability required to display this menu
		'custom-login-shortcodes', 	// The unique slug name to refer to this menu
		'clsc_html_page');			// The function to output the page content

	// Activate custom settings
	add_action('admin_init','clsc_custom_setting');
}
add_action('admin_menu', 'add_clsc_option_admin_page');

// Register settings for wordpress to handle all values
function clsc_custom_setting() {  

    register_setting('clsc-settings-group', 'clsc_options_array', 'clsc_sanitize_callback');

}

function clsc_sanitize_callback( $input ) {

	// Initialize the new array that will hold the sanitize values
	$new_input = array();

	// Loop through the input and sanitize each of the values
	foreach ($input as $key => $val) {

		$new_input[ $key ] = sanitize_text_field( $val );

	}

	return $new_input;

}

// Enqueue admin scripts
function clsc_enqueue_scripts() {
	global $wpdb;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_custom-login-shortcodes' ) {
		return; // exit if incorrect screen id
	} 
    
    wp_enqueue_script('admin_js_bootstrap_hack', plugins_url('admin/scripts/bootstrap-hack.js', dirname(__FILE__) ) );
}
add_action('admin_enqueue_scripts', 'clsc_enqueue_scripts' );

function clsc_html_page() {

	require_once('admin-page.php');

}

?>