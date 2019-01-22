<?php

// REST API

// Basic Simple Message ============================

//add top-level administrative menu
function loginadmin_rest_add_toplevel_menu() {

  add_menu_page(
    'REST API: Basic Simple Message',
    'REST API: Basic',
    'manage_options',
    'rest-simple',
    'loginadmin_rest_cb_display_settings_page',
    'dashicons-admin-generic',
    null
  );

}
add_action('admin_menu','loginadmin_rest_add_toplevel_menu');


//display the plugin settings page
function loginadmin_rest_cb_display_settings_page() {
    //check if user is allowed access
    if (!current_user_can('manage_options')) return;

    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() );?></h1>
      <p>
        <?php _e( 'This plugins demonstrates how to use the REST API.', 'loginadmin' ) ?>
        <?php _e( 'Click button to display message.', 'loginadmin' ) ?>
      </p>
      <input type="submit" id="rest-button" class="button button-primary" value="Get Special Message">
      <div id="rest-response"></div>

    </div>

    <?php
}

//enqueue scripts
function loginadmin_rest_enq_scripts($hook) {
  //check if our page
  if ('toplevel_page_rest-simple' !== $hook) return;

  //define rest url
  $url = wp_json_encode( esc_url_raw( rest_url('basic/v2/test') ) );

  //define script
  $script = '
   jQuery(document).ready(function($){
     $("#rest-button").on("click", function(){
       $.ajax({
         url: '.$url.'
       }).done(function(data){
         $("#rest-response").append(data);
       });
     });

   });
   ';

   //add inline script (WP>=4.5)
//   wp_add_inline_script('jquery-core', $script); // 
   wp_add_inline_script('jquery-ui-widget', $script);
}
add_action('admin_enqueue_scripts','loginadmin_rest_enq_scripts');


//register rest route //custom route
function loginadmin_rest_register_route() {

  register_rest_route(
      'basic/v2',
      '/test',
      array(
        'methods' => 'GET',
        'callback' => 'rest_cb_special_message'
      )
  );

}
add_action( 'rest_api_init', 'loginadmin_rest_register_route' );


//callback function
function rest_cb_special_message() {
  return '<p> This is the special message of Raymacz! </p>';
}


// REST API: Display Recent Posts ============================


//add top-level administrative menu
function loginadmin_rest_add_toplevel_menu_rp() {

  add_menu_page(
    'REST API: Display Posts',
    'REST API: Advanced',
    'manage_options',
    'rest-read-posts',
    'loginadmin_rest_cb_display_settings_page_rp',
    'dashicons-admin-generic',
    null
  );

}
add_action('admin_menu','loginadmin_rest_add_toplevel_menu_rp');


//display the plugin settings page
function loginadmin_rest_cb_display_settings_page_rp() {
    //check if user is allowed access
    if (!current_user_can('manage_options')) return;

    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() );?></h1>
      <p>
        <?php _e( 'This plugins demonstrates how to use the REST API.', 'loginadmin' ) ?>
        <?php _e( 'Click the button to view some recent posts.', 'loginadmin' ) ?>
      </p>
      <input type="submit" id="rest-button" class="button button-primary" value="View Posts">
      <div id="rest-container"></div>

    </div>

    <?php

}


// enqueue scripts //use endpoints provided by WP
function loginadmin_rest_enq_scripts_rp($hook) {
  //check if our page
  if('toplevel_page_rest-read-posts' !==$hook) return;
  //define script url
  $script_url =plugins_url( '/admin/js/rest-read-posts.js', PLUGIN_BASE_PATH );
  //enqueue script
  wp_enqueue_script( 'rest-read-posts', $script_url, array(), null, true );
//  wp_enqueue_script( 'rest-read-posts', $script_url, array('jquery'));
  //add inline script
  wp_localize_script(
        'rest-read-posts',
        'rest_read_posts',
        array(
            'root' => esc_url_raw( rest_url() )
        )
  );
}
add_action('admin_enqueue_scripts','loginadmin_rest_enq_scripts_rp');
