<?php 

// Buidling the HTML page

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

    <div class="bootstrap-wrapper">

    	<div class="row">
            <div class="col-md-12">
                <h1><?php _e('Custom Login Shortcode','clsc'); ?></h1>
                <p><?php _e('To use for shortcode:','clsc'); ?><br/><span class="shortcode-preview">[custom_login]</span></p>
            </div>
        </div>

        <form method="post" action="options.php"> 
            <?php 

            $options = get_option('clsc_options_array');

            settings_fields('clsc-settings-group');

            ?>
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
        </form>
    </div>

    <?php

?>