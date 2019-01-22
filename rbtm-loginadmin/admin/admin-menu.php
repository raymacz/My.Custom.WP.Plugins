<?php // loginadmin - Admin Menu

// exit if file is called directly
if ( ! defined ('ABSPATH')) {
   exit;
}



// add top-level administrative menu
function loginadmin_add_toplevel_menu(){
     /*
      *        admin_menu_page(
      *             string      $page_title,
      *             string      $menu_title,
      *             string      $capability,
      *             string      $menu_slug,
      *             callable    $function = '',
      *             string      $icon_url ='',
      *             int         $position = null
      *        )
      */


     add_menu_page(
             'LoginAdmin Settings',
             'LoginAdmin',
             'manage_options',
             'loginadmin',
             'loginadmin_display_settings_page',
             'dashicons-admin-generic',
             null);

}

add_action('admin_menu', 'loginadmin_add_toplevel_menu'); //enable this for toplevel instead of sublevel menu



// add sub-level administrative menu

function loginadmin_add_sublevel_menu(){
     /*
      *        admin_menu_page(
      *             string      $parent_slug,
      *             string      $page_title,
      *             string      $menu_title,
      *             string      $capability,
      *             string      $menu_slug,
      *             callable    $function = '',
      *        )
      */


     add_submenu_page(
             'options-general.php',
             'LoginAdmin Settings',
             'LoginAdmin',
             'manage_options',
             'loginadmin',
             'loginadmin_display_settings_page'
             );

}

//add_action('admin_menu', 'loginadmin_add_sublevel_menu');

