<?php

// custom loop shortcode: [wp_query_scode]

function loginadmin_custom_loop_wp_query_shortcode($atts) {

  // check if transient email_exists
  if (false === ($posts = get_transient('loginadmin_wp_query'))) {
    //define shortcode variables
    extract(shortcode_atts(array(
      'posts_per_page' => 5,
      'orderby' => 'date'
      ),
    $atts));

    //define query paramaters
    $args = array(
      'posts_per_page' => $posts_per_page,
      'orderby' => $orderby
    );
    //query the posts
    $posts = new WP_Query($args);
    //set transient to cache results for 12hours / 60 seconds
    set_transient( 'loginadmin_wp_query', $posts, 12 * HOUR_IN_SECONDS );
//    set_transient( 'loginadmin_wp_query', $posts, 60 ); //seconds

  }

  //begin output variable
  $output = '<h3>'.esc_html__('Custom Loop Ex: WP_Query','loginadmin').'</h3>';

  //begin the loop

    // The Loop
    if ( $posts->have_posts() ) :
      while ( $posts->have_posts() ) : $posts->the_post();
      	$output .= '<h4><a herf="'.get_permalink().'">'.get_the_title().'</a></h4>';
        $output .= get_the_content();
      endwhile;
      //add pagination here
      //add comments here
      wp_reset_postdata(); /* Restore original Post Data */
    else :
      $output .= esc_html__('Sorry, no posts matched your criteria.','loginadmin');
    endif;

    return $output;
 
}
// register shortcode function
add_shortcode( 'wp_query_scode', 'loginadmin_custom_loop_wp_query_shortcode' );

//delete transient on plugin deactivation
function loginadmin_custom_loop_wp_query_on_deactivaiton() {
  if (!current_user_can('activate_plugins')) return;
  delete_transient( 'loginadmin_wp_query' );
}
register_deactivation_hook( __FILE__, 'loginadmin_custom_loop_wp_query_on_deactivaiton' );
