<?php

/*
Plugin Name: Rbtm Login Admin
Description:  a way to add customization to WP admin & WP login.
Author: Raymacz
Author URI: http://webmacz.cf
Version: 1.0
Text Domain: rbtm-loginadmin
Domain Path: /languages
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// exit if file is called directly
if ( ! defined ('ABSPATH')) {
   exit;
}

//load text domain for internationalization

function logindomain_load_textdomain() {
    load_plugin_textdomain('rbtm-logindomain', false, plugin_dir_path( __FILE__ ).'languages/');
}
add_action('plugins_loaded', 'logindomain_load_textdomain');

//if admin area
if (is_admin()) {

    // include dependencies
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';

}

define('PLUGIN_BASE_PATH', __FILE__); // initialized path so plugin registration hook will work
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';
//require_once plugin_dir_path( __FILE__ ) . 'uninstall.php';

 // Post Custom Query by adding it on any page template using shortcode
require_once plugin_dir_path( __FILE__ ) . 'includes/post-query.php';

// Create Custom Widget -  Clean Markup Widget
    require_once plugin_dir_path( __FILE__ ) . 'includes/cust-widget.php';

// Manage users and roles
    require_once plugin_dir_path( __FILE__ ) . 'includes/add-users.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/update-users.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/del-users.php';
    require_once plugin_dir_path( __FILE__ ) . 'includes/role-cap-users.php';

// metaboxes
    require_once plugin_dir_path( __FILE__ ) . 'includes/my-metabox.php';
// wpdb Wordpress database
    require_once plugin_dir_path( __FILE__ ) . 'includes/my-wpdb.php';
// transient API
    require_once plugin_dir_path( __FILE__ ) . 'includes/my-transient.php';
// HTTP API Request for POST & GET
   require_once plugin_dir_path( __FILE__ ) . 'includes/http-api-get-request.php';
// WP Cron
   require_once plugin_dir_path( __FILE__ ) . 'includes/my-wp-cron.php';
// AJAX
   require_once plugin_dir_path( __FILE__ ) . 'includes/my-ajaxadmin.php';
   require_once plugin_dir_path( __FILE__ ) . 'includes/my-ajaxpublic.php';
// REST API
   require_once plugin_dir_path( __FILE__ ) . 'includes/my-restapi.php';

//default plugin options value
function loginadmin_options_default() {
    return array(
        'custom_url' => 'http://webmacz.cf/',
        'custom_title' => esc_html__('Powered by Wordpress','rbtm-loginadmin'),
        'custom_style' => 'disable',
        'custom_message' => '<p class="custom-message">'.esc_html__("My custom message","rbtm-loginadmin").'</p>',
        'custom_footer' => esc_html__('Special message for users','rbtm-loginadmin'),
        'custom_toolbar' => false,
        'custom_scheme' => 'default',

    );
}


////remove options on uninstall
//function loginadmin_on_uninstall() {
//    if (!current_user_can('activate_plugins')) return;
//    delete_option('loginadmin_options');
//}
//register_uninstall_hook(__FILE__, 'loginadmin_on_uninstall');
