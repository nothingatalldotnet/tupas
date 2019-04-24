<?php
	if(function_exists('acf_add_options_page')) {
		acf_add_options_page(array(
			'page_title' => 'TUPAS Settings',
			'menu_title' => 'TUPAS Settings',
			'menu_slug' => 'tupas-settings',
			'capability' => 'edit_posts',
			'position' => 2,
			'redirect' => false,
			'autoload' => true
		));
	}