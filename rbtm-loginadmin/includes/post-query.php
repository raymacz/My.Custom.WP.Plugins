<?php

/*
 * // Post Custom Query by adding it on any page template using shortcode
 */


// Post Custom Query by adding it on any page template
// shortcode: [wp_query_cust posts_per_page="5" orderby="date" order="ASC"]
function custom_loop_sc_wpquery($atts) {
  $args = array(
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    );
  $atts = shortcode_atts($args, $atts);
  extract($atts);
    // the query
    $query = new WP_Query( $atts );
    $output = '<h3>'. esc_html__('Query Output: ','loginadmin_options') .'</h3>';
    // The Loop
    if ( $query->have_posts() ) :
      while ( $query->have_posts() ) : $query->the_post();
    	// contents of the Loop go here
        $output .= '<h4><a href="'.get_the_permalink().'">' .  get_the_title().'</a></h4>';
        $output .= get_the_content();
      endwhile;
      wp_reset_postdata(); /* Restore original Post Data */
    endif;
  return $output;
}
add_shortcode( 'wp_query_cust', 'custom_loop_sc_wpquery' );