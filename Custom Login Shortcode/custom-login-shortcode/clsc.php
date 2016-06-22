<?php
/*
Plugin Name: Custom Login Shortcode
Plugin URI: https://www.brokenfruit.dk/
Description: Adds a custom login shortcode to be used anywhere on your website. Outputs a simple href attributes with links, strings and classes defined by you.
Version: 1.0
Author: Kenn Nielsen
Author URI: https://www.brokenfruit.dk/
Text Domain: clsc
Domain Path: /languages
*/

// Meaning of abbreviations:
// clsc = custom login shortcode

define ('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define ('PLUGIN_MAIN_FILE',__FILE__);

// Include admin.php if admin user
if ( is_admin() ) {
	require_once( MY_PLUGIN_PATH .  'admin/admin.php');
}

// Enqueue front end styles
function clsc_enqueue_frontend() {

	wp_enqueue_style( 'clsc_FontAwesome', plugins_url( '/fonts/FontAwesome/css/font-awesome.min.css', __FILE__) );

}
add_action('wp_enqueue_scripts', 'clsc_enqueue_frontend');


// Load textdomain
function clsc_load_plugin_textdomain() {
    load_plugin_textdomain( 'clsc', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'clsc_load_plugin_textdomain' );

/*---------------------------------------------------*/
/*          Custom login shortcode - start           */
/*---------------------------------------------------*/

if (!function_exists(custom_login_shortcode)) {

    function custom_login_shortcode ( $atts, $content = null ){

        // get options from database and put it into $options variable. Ensure a single call to db.
            $options = get_option('clsc_options_array');

        if ( is_user_logged_in() ) {

            $output = '<i class="fa icon-user"></i><a href="';
            $output .= $options['Account_link'];
            $output .= '" class="';
            $output .= $options['Account_class'];
            $output .= '">';
            $output .= $options['Account_string'];
            $output .= '</a> | <i class="fa icon-logout"></i><a href="';
            $output .= $options['Logout_link'];
            $output .= '" class="';
            $output .= $options['Logout_class'];
            $output .= '">';
            $output .= $options['Logout_string'];
            $output .= '</a>';
            
            return $output;

        } else {

            $output = '<i class="fa icon-login"></i><a href="';
            $output .= $options['Login_link'];
            $output .= '" class="';
            $output .= $options['Login_class'];
            $output .= '">';
            $output .= $options['Login_string'];
            $output .= '</a>';

            return $output;
        }
    }
    add_shortcode( 'custom_login', 'custom_login_shortcode' );
    add_action ('init', 'custom_login_shortcode');
    
}
/*---------------------------------------------------*/
/*          Custom login shortcode - end             */
/*---------------------------------------------------*/

?>