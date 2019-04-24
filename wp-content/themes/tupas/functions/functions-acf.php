<?php

	function acfMapsKey() {
		acf_update_setting('google_api_key', '');
	}
	add_action('acf/init', 'acfMapsKey');