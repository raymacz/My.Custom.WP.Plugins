<?php

//Wordpress AJAX

//enqueue scripts

function loginadmin_ajax_admin_enq_scripts($hook) {

  //check if page url is in the plugin page so javascript can load // good for performance
  // Load CSS File from a plugin on specific Admin Page - https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
    if ('settings_page_role-users' !== $hook) return;
//  if ('toplevel_page_ajax-admin-example' !== $hook) return;

  // define script url
  $script_url = plugins_url('/admin/js/ajax-admin.js', PLUGIN_BASE_PATH);

  // enqueue script
  wp_enqueue_script('ajax-admin', $script_url, array('jquery'));

  // create nonce
  $nonce = wp_create_nonce('ajax_admin');

  // define script
  $script = array ('nonce' => $nonce);

  //localize script - this passes the value to the javascript file variable
  wp_localize_script('ajax-admin', 'ajax_admin', $script);
}
add_action('admin_enqueue_scripts', 'loginadmin_ajax_admin_enq_scripts');


// process ajax request
function loginadmin_ajax_admin_handler() {
    //check nonce
    check_ajax_referer('ajax_admin', 'nonce');

    //check user
    if(!current_user_can('manage_options')) return;

    //define the url
    $url =isset($_POST['url']) ? esc_url_raw($_POST['url']) : false;

    // make head request
    $response = wp_safe_remote_get($url, array('method' => 'HEAD'));

    //get response headers
    $headers = wp_remote_retrieve_headers($response);

    //output the results
    echo '<pre>';

    if(!empty($headers)) {
        echo 'Response headers for: '.$url.'\n\n';
        print_r($headers);
    } else {
        echo 'No results, Please check the URL and try again.';
    }

    echo '</pre>';

    //end processing
    wp_die();

}
// ajax hook for logged-in users: wp_ajax_{action} https://codex.wordpress.org/Plugin_API/Action_Reference/wp_ajax_(action)
// admin_hook - name of the action that is passed in the POST request via jQuery post method.
add_action('wp_ajax_admin_hook','loginadmin_ajax_admin_handler');


//display form and results
function loginadmin_ajax_admin_display_form() {
?>
    <style>
       .ajax-form-wrap {width:100%; overflow: hidden; margin: 0 0 20px 0;}
       .ajax-form {float: left; width: 400px;}
       .examples {float: left; width: 200px;}
       pre {
           width:95%; overflow: auto; margin: 20px 0; padding: 20px;
           color: #fff; background-color: #424242;
       }
    </style>
    <h3>Check Headers</h3>
    <p>This plugin uses AJAX to send a HEAD request.</p>
    <div class="ajax-form-wrap">
      <form class="ajax-form" method="post">
        <p><label for="url">Enter any valid URL:</label></p>
        <p><input id="url" name="url" type="text" class="regular-text"></p>
        <input type="submit" value="Check Headers" class="button button-primary">
      </form>

      <div class="examples">
        <p>Examples:</p>
        <ul>
          <li><code>https://yahoo.com/</code></li>
          <li><code>https://google.com/</code></li>
          <li><code>https://api.github.com/</code></li>
        </ul>
      </div>

    </div>
    <!-- used by jQuery script to display results, check ajax-admin.js -->
    <div class="ajax-response"></div>

<?php
}
