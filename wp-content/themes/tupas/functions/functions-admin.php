<?php
	/**
	 * Add favicon to the back end
	 */
	function add_site_favicon() {
	//    echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/assets/images/cropped-Anexsys-A-32x32.png" />';
	}
	add_action('login_head', 'add_site_favicon');
	add_action('admin_head', 'add_site_favicon');


	/**
	 * Remove admin bar margin from the top of HTML
	 */
	function ken_remove_admin_bar_bump() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	add_action('get_header', 'ken_remove_admin_bar_bump');

	/**
	 * Remove the colour options
	 */
	remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');