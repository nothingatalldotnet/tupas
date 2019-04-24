<?php
    function remove_default_post_type() {
        remove_menu_page('edit.php');
    }
    add_action('admin_menu', 'remove_default_post_type');

    function remove_default_post_type_menu_bar($wp_admin_bar) {
        $wp_admin_bar->remove_node('new-post');
    }
    add_action('admin_bar_menu', 'remove_default_post_type_menu_bar', 999);

    function remove_draft_widget() {
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    }
    add_action('wp_dashboard_setup', 'remove_draft_widget', 999);


    // post types
    function create_post_type() {
        register_post_type('News',
            array(
                'labels' => array(
                    'name' => __('News'),
                    'singular_name' => _('News')
                ),
                'show_in_nav_menus' => true,
                'menu_position'=> 20,
                'menu_icon' => 'dashicons-megaphone',
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'supports' => array('title','revisions'),
                'rewrite' => array(
                    'slug'  => 'news',
                    'pages' => true,
                    'with_front' => true
                ),
            )
        );
        register_post_type('Blog',
            array(
                'labels' => array(
                    'name' => __('Blog'),
                    'singular_name' => _('Blog')
                ),
                'show_in_nav_menus' => true,
                'menu_position'=> 21,
                'menu_icon' => 'dashicons-admin-post',
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'supports' => array('title','revisions'),
                'rewrite' => array(
                    'slug'  => 'blog',
                    'pages' => true,
                    'with_front' => true
                ),
            )
        );
        register_post_type('Articles',
            array(
                'labels' => array(
                    'name' => __('Articles'),
                    'singular_name' => _('Article')
                ),
                'show_in_nav_menus' => true,
                'menu_position'=> 22,
                'menu_icon'=>'dashicons-align-left',
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'supports' => array('title','revisions'),
                'rewrite' => array(
                    'slug'  => 'articles',
                    'pages' => true,
                    'with_front' => true
                ),
            )
        );
        register_post_type('Gallery',
            array(
                'labels' => array(
                    'name' => __('Gallery'),
                    'singular_name' => _('Gallery')
                ),
                'show_in_nav_menus' => true,
                'menu_position'=> 23,
                'menu_icon'=>'dashicons-camera',
                'public' => true,
                'has_archive' => true,
                'query_var' => true,
                'supports' => array('title','revisions'),
                'rewrite' => array(
                    'slug'  => 'gallery',
                    'pages' => true,
                    'with_front' => true
                ),
            )
        );
    }
    add_action('init','create_post_type');