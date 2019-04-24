<?php
	function enqueue_scripts() {
		// Google Maps API
//		wp_enqueue_script( 'gmaps-api', '//maps.googleapis.com/maps/api/js?key=AIzaSyCstof6LcDKAydXIbEGH7RH7E3itd8Y5xM', null, null, true );

		wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), 'v' . filemtime( get_stylesheet_directory() . '/assets/js/scripts.min.js'), true );

		wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), 'v' . filemtime( get_stylesheet_directory() . '/assets/css/style.css'), 'all' );

		wp_localize_script( 'custom-js', 'ajaxUrl', array( 
			'url' => admin_url() . 'admin-ajax.php',
		) );
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_scripts');


	function add_admin_style() {
		wp_enqueue_style( 'tupas-admin-style', get_stylesheet_directory_uri() . '/style-admin.css', array(), 'v' . filemtime( get_stylesheet_directory() . '/style-admin.css'), 'all' );
	}
	add_action('admin_head', 'add_admin_style');