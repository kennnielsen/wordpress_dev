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

// Register settings for wordpress to handle all values
function admin_init_register_setting()
{    
    register_setting('wp_plugin_template-group', 'clsc_options_array');

}
add_action('admin_init','admin_init_register_setting');


// Create admin option page
function add_clsc_option_page() {
	add_options_page(
		'Custom Login', 			// The text to be displayed in the title tag
		'Custom Login', 			// The text to be used for the menu
		'administrator', 			// The capability required to display this menu
		'custom-login-shortcodes', 	// The unique slug name to refer to this menu
		'clsc_html_page');			// The function to output the page content
}
/* Call the html code */
add_action('admin_menu', 'add_clsc_option_page');

// Enqueue admin styles and scripts
function clsc_enqueue_scripts() {
	global $wpdb;
	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_custom-login-shortcodes' ) {
		return; // exit if incorrect screen id
	} 
    
    wp_enqueue_script('admin_js_bootstrap_hack', plugins_url('admin/scripts/bootstrap-hack.js', dirname(__FILE__) ) );
}
add_action('admin_enqueue_scripts', 'clsc_enqueue_scripts' );

function clsc_html_page()
{
    if(!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.','clsc') );
    }

    ?>

    <script type="text/javascript">

    	$j = jQuery.noConflict();

    	var default_logout = <?php echo json_encode( wp_logout_url( home_url()) ); ?>;

    	$j(document).ready(function(){
		    $j("#logout-default").click(function(){
		        $j("#logout-field").val(default_logout);
		    });
		});
    </script>

    <div class="wrap">

        <form method="post" action="options.php"> 
            <?php 

            $options = get_option('clsc_options_array');     
            settings_fields('wp_plugin_template-group');
            do_settings_fields('wp_plugin_template-group'); 

            ?>          
            <div class="bootstrap-wrapper">
	            <div class="row">
	                <div class="col-md-12">
	                    <h1><?php _e('Custom Login Shortcode','clsc'); ?></h1>
	                    <p><?php _e('To use for shortcode:','clsc'); ?><br/><span class="shortcode-preview">[custom_login]</span></p>
	                </div>
	            </div>
	            <div class="row" id="login-content">
	                <div class="col-md-4">
	                    <h5><?php _e('Log in link:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Login_link]" placeholder="<?php _e('Example: log-in/', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Login_link']; ?>" />
	                </div>
	                <div class="col-md-4">
	                    <h5><?php _e('Log in string:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Login_string]" placeholder="<?php _e('Example: Log in', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Login_string']; ?>" />
	                </div>
	                <div class="col-md-4">
	                    <h5><?php _e('Log in class:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Login_class]"  placeholder="<?php _e('Example: login_style', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Login_class']; ?>" />
	                </div>
	            </div>
	            <div class="row top-buffer" id="logout-content">
	                <div class="col-md-4">
	                    <h5><?php _e('Log out link:','clsc'); ?></h5>
	                    <input id="logout-field" name="clsc_options_array[Logout_link]" placeholder="<?php _e('Example: log-out/', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Logout_link']; ?>" />
	                	<input class="btn btn-default btn-xs" type="button" name="logout-default" id="logout-default" value="<?php _e('Use default logout link','clsc') ?>"/>
	                </div>
	                <div class="col-md-4">
	                    <h5><?php _e('Log out string:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Logout_string]" placeholder="<?php _e('Example: Log out', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Logout_string']; ?>" />
	                </div>
	                <div class="col-md-4">
	                    <h5><?php _e('Log out class:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Logout_class]" placeholder="<?php _e('Example: logout_style', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Logout_class']; ?>" />
	                </div>
	            </div>
	            <div class="row top-buffer" id="account-content">
	                <div class="col-md-4">
	                    <h5><?php _e('Account link:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Account_link]" placeholder="<?php _e('Example: my-account/', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Account_link']; ?>" />
	                </div>
	                <div class="col-md-4">
	                    <h5><?php _e('Account string:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Account_string]" placeholder="<?php _e('Example: My Account', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Account_string']; ?>" />
	                </div>
	                <div class="col-md-4">
	                    <h5><?php _e('Account class:','clsc'); ?></h5>
	                    <input name="clsc_options_array[Account_class]" placeholder="<?php _e('Example: account_style', 'clsc') ?>" class="form-control" type="text" value="<?php echo $options['Account_class']; ?>" />
	                </div>
	            </div>
	            <div class="row top-buffer" id="submit">
	                <div class="col-md-4">
	                    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="<?php _e('Save Changes', 'clsc') ?>" />
	                </div>
	            </div> 

            <!--<?php submit_button( __('Save Changes', 'clsc') ); ?>-->

            </div>
            
        </form>

    </div>

    <?php
}
?>