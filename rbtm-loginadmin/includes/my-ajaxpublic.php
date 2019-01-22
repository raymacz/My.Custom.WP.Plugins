<?php

//Wordpress AJAX

//enqueue scripts

function loginadmin_ajax_public_enq_scripts($hook) {


    // define public ajax url unlike in admin that was automatically defined by WP (to display)
  $ajax_url = admin_url( 'admin-ajax.php' );

  // define script url - file
  $script_url = plugins_url('/admin/js/ajax-public.js', PLUGIN_BASE_PATH);

  // enqueue script
  wp_enqueue_script('ajax-public', $script_url, array('jquery'));

  // create nonce
  $nonce = wp_create_nonce('ajax_public');

  // define script
  $script = array ('nonce' => $nonce, 'ajaxurl' => $ajax_url);

  //localize script - this passes the value to the javascript file variable
  wp_localize_script('ajax-public', 'ajax_public', $script);
}
 add_action('wp_enqueue_scripts', 'loginadmin_ajax_public_enq_scripts');


// process ajax request
function loginadmin_ajax_public_handler() {
    //check nonce
    check_ajax_referer('ajax_public', 'nonce');

    //define the url
    $author_id =isset($_POST['author_id']) ? $_POST['author_id'] : false;

    // define user description
    $description = get_user_meta($author_id, 'description', true);
    $all_metavalues= get_user_by('ID',$author_id);
    // get_user_metavalues($ids) //deprecated

    //output the results
    echo esc_html($description);
    echo '<br /><br /><pre>All User Metavalues: ';
    if(!empty($all_metavalues)) {
//        print_r($all_metavalues);
        var_dump($all_metavalues);
    } else {
        echo 'No results, Please check Author\'s Biography or metadata.';
    }
    echo '</pre>';

    //end processing
    wp_die();

}
// ajax hook for logged-in users:  - https://codex.wordpress.org/Plugin_API/Action_Reference/wp_ajax_(action)
//  name of the action that is passed in the POST request via jQuery post method.
 add_action('wp_ajax_public_hook','loginadmin_ajax_public_handler'); // This hook allows you to handle your custom AJAX endpoints
 // wp_ajax_no_priv_{action} ajax hook for non-logged-in users: - https://developer.wordpress.org/reference/hooks/wp_ajax_nopriv__requestaction/
 add_action('wp_ajax_nopriv_public_hook','loginadmin_ajax_public_handler');


//display form and results
function loginadmin_ajax_public_display_form($content) {

  if (!is_single()) return $content;

  $id = get_the_author_meta( 'ID' );
  $url = get_author_posts_url($id);
  $markup = '<p id="get-data" class="ajax-learn-more">';
  $markup .= '<a href="'.$url.'" data-id="'.$id.'">';
  $markup .= 'View Author Information</a></p>';
  $markup .= '<div class="ajax-response"></div>';

  return $content.$markup;
}
add_filter('the_content','loginadmin_ajax_public_display_form');
