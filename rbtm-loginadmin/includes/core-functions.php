<?php

/*
 * loginadmin -  Core
 */

// exit if file is called directly
if ( ! defined ('ABSPATH')) {
   exit;
}


//custom login logo url
function loginadmin_custom_login_url ($url) {

    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_url']) && !empty($options['custom_url'])) {
        $url = esc_url($options['custom_url']);
    }

    return $url;
}
add_filter('login_headerurl', 'loginadmin_custom_login_url');


//custom login logo title
function loginadmin_custom_login_title ($title) {
    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_title']) && !empty($options['custom_title'])) {
        $title = esc_attr($options['custom_title']);
    }

    return $title;
}
add_filter('login_headertitle', 'loginadmin_custom_login_title');

// custom style //todo

function loginadmin_custom_login_styles() {

    $styles = FALSE;
    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_style']) && !empty ($options['custom_style'])) {
        $styles = sanitize_text_field($options['custom_style']);
    }
//    echo '<pre>rbtm ';
//     var_dump($styles);
//    echo '</pre>';
    if ('enable' === $styles) {
      wp_enqueue_style('loginadmin-style', plugin_dir_url(dirname(__FILE__)).'public/css/loginadmin-login.css', array(), false, 'screen');
      wp_enqueue_script('loginadmin-js', plugin_dir_url(dirname(__FILE__)).'public/js/loginadmin-login.js', array('jquery'), false, true);
//      wp_enqueue_script('framemacz-script-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'), '20171225', true);
    }

}
add_action('login_enqueue_scripts', 'loginadmin_custom_login_styles');



//custom login message
function loginadmin_custom_login_message ($msg) {
    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_message']) && !empty($options['custom_message'])) {
        $msg = wp_kses_post($options['custom_message']);
    }

    return $msg;
}
add_filter('login_message', 'loginadmin_custom_login_message');


//custom admin footer
function loginadmin_custom_admin_footer ($msg) {
//    echo '<pre>rbtm ';
//    var_dump($msg);
//    echo '</pre>';
    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_footer']) && !empty($options['custom_footer'])) {
        $msg = sanitize_text_field($options['custom_footer']);
    }

    return $msg;
}
add_filter('admin_footer_text', 'loginadmin_custom_admin_footer');


//custom toolbar items
function loginadmin_custom_admin_toolbar () {
    $toolbar = false;
    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_toolbar']) && !empty($options['custom_toolbar'])) {
        $toolbar = (bool)($options['custom_toolbar']);
    }
    if ($toolbar) {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('new-content');
    }

}
add_action('wp_before_admin_bar_render', 'loginadmin_custom_admin_toolbar', 999);

//custom admin color scheme
function loginadmin_custom_admin_scheme ($user_id) {
    $scheme = 'default';
    $options = get_option('loginadmin_options', loginadmin_options_default());
    if (isset($options['custom_scheme']) && !empty($options['custom_scheme'])) {
        $scheme = sanitize_textarea_field($options['custom_scheme']);
    }
    $args = array( 'ID' => $user_id, 'admin_color' => $scheme);
    wp_update_user($args);
}
add_action('user_register', 'loginadmin_custom_admin_scheme');
