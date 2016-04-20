<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
	/* Deletes the database fields */
	delete_option('clsc_options_array');

?>