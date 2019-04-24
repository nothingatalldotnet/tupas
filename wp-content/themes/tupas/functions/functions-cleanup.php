<?php

	/**
	 * Remove various head bits
	 */
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
  	remove_action('wp_head', 'feed_links', 2);
  	remove_action('wp_head', 'feed_links_extra', 3);
  	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head');
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
  	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
	remove_action('rest_api_init', 'create_initial_rest_routes', 99);

	/**
	 * Remove jQuery
	 */
	if(!is_admin()) {
	    add_action( 'wp_enqueue_scripts', function(){
	        wp_deregister_script( 'jquery' );
	        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', array(), null, false );
	        wp_enqueue_script('jquery');
	    });
	}

	/**
	 * Hide query strings in URLs
	 */
	function hide_query_strings($src){ 
		$parts = explode( '?', $src ); 
		return $parts[0]; 
	} 
	// add_filter('script_loader_src', 'hide_query_strings', 15, 1 ); 
	// add_filter('style_loader_src', 'hide_query_strings', 15, 1 );

	/**
	 * Remove widgets
	 */
	add_action('widgets_init', function() {
		unregister_widget('WP_Widget_Calendar');
		unregister_widget('WP_Widget_Recent_Comments');
	});

	/**
	 * Remove some dashboard bits
	 */
	add_action('admin_init', function() {
		remove_action('welcome_panel', 'wp_welcome_panel');
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
	});

	/**
	 * 	Hide the WP version
	 */
	function remove_wp_version() {
		return '';
	}
	add_filter('the_generator', 'remove_wp_version');

	/**
	 * Strip the emojis
	 */
	add_action('init', function () {
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		add_filter('emoji_svg_url', '__return_false');
		remove_action('admin_print_scripts', 'print_emoji_detection_script');
		remove_action('admin_print_styles', 'print_emoji_styles');
		add_filter('tiny_mce_plugins', function ($plugins) {
			if(is_array($plugins)) {
				return array_diff($plugins, array('wpemoji'));
			}
			return array();
		});
		remove_filter('the_content_feed', 'wp_staticize_emoji');
		remove_filter('comment_text_rss', 'wp_staticize_emoji');
		remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	});

	/**
	* Disable Gutenberg
	*/
	add_filter('gutenberg_can_edit_post_type', '__return_false', 10);
	add_filter('gutenberg_can_edit_post', '__return_false', 10);
	add_filter('use_block_editor_for_post', '__return_false', 10);
	add_filter('use_block_editor_for_post_type', '__return_false', 1);

	function disable_gutenberg_cpt($is_enabled, $post_type) {
		if ($post_type === 'products') return false;
		if ($post_type === 'news') return false;
		return $is_enabled;
	}
	add_filter('use_block_editor_for_post_type', 'disable_gutenberg_cpt', 10, 2);
	add_filter('gutenberg_can_edit_post_type', 'disable_gutenberg_cpt', 10, 2);

	/**
	 * Update the footer
	 */
	function remove_footer_admin () {
 		echo "Hammered together by <a href='https://nothingatall.net/' target='_blank'>nothingatall.net</a>";
	}
	add_filter('admin_footer_text', 'remove_footer_admin');

	/**
	 * Update the login logo
	 */
	function update_logo() { 
	}
	add_action('login_head', 'update_logo');

	/**
	 * Remove the Customise menu
	 */
	function remove_customise() {
		$request = urlencode($_SERVER['REQUEST_URI']);
		remove_submenu_page('themes.php', 'customize.php?return='. $request);
	}
	add_action('admin_menu', 'remove_customise');

	/**
	 * Block subscribers from accessing the admin
	 */
	function subscriber_no_admin_access() {
		$redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
		global $current_user;
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);
		if($user_role === 'subscriber'){
			exit( wp_redirect( $redirect ) );
		}
	}
	add_action('admin_init', 'subscriber_no_admin_access', 100);

	/**
	 * Disable the W3 cache comment
	 */
	add_filter('w3tc_can_print_comment', '__return_false', 10, 1);

	/** 
	* Add an browser and OS body classes
	**/
	function wt_browser_body_class($classes) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_edge, $is_chrome, $is_iphone;

		// Browser and os
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_edge) $classes[] = 'edge';
		elseif($is_IE) {
			$classes[] = 'ie';
			if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
				$classes[] = 'ie'.$browser_version[1];
		} else $classes[] = 'unknown';

		if($is_iphone) $classes[] = 'iphone';

		if(stristr($_SERVER['HTTP_USER_AGENT'],"mac")) {
			$classes[] = 'osx';
		} elseif(stristr($_SERVER['HTTP_USER_AGENT'],"linux")) {
			$classes[] = 'linux';
		} elseif(stristr($_SERVER['HTTP_USER_AGENT'],"windows")) {
			$classes[] = 'windows';
		}

		// Now the site speific
		if(is_archive()) {
			if(is_post_type_archive('tests')) {
				$classes[] = 'archive';
			} else if(is_post_type_archive('news')) {
				$classes[] = 'archive';
			} else {
				$classes[] = 'single-brand';
			}
		} elseif(is_single()) {
			$pt = get_post_type();
			if($pt == "news") {
				$classes[] = 'single-post';
			} else if($pt == "products") {
				$classes[] = 'single-tyre';
			} else if($pt == "tests") {
			} else {
			}
		} elseif(is_tax()) {
			$classes[] = 'single-brand';
		} elseif(is_page('search-results')) {
			$classes[] = 'site-search-results';
		} elseif(is_page('search-tyres')) {
			$classes[] = 'tyre-search-results';
		} else {
		}

		return $classes;
	}
	add_filter('body_class','wt_browser_body_class');