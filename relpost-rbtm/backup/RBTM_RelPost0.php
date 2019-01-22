<?php
/*
Plugin Name: RelPost RBTM
Description: Displays clickable related posts thru REST API
Version:     0.1
Author:      Raymacz
Author URI:  http://webmacz.cf
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: RBTM_RelPost
*/

// Add various fields to the JSON output
function RBTM_RelPost_register_fields() {
	// Add Author Name
	register_rest_field( 'post',
		'author_name',
		array(
			'get_callback'		=> 'RBTM_RelPost_get_author_name',
			'update_callback'	=> null,
			'schema'		=> null
		)
	);

	// Add Featured Image
	register_rest_field( 'post',
		'featured_image_src',
		array(
			'get_callback'		=> 'RBTM_RelPost_get_image_src',
			'update_callback'	=> null,
			'schema'		=> null
		)
	);

        // Add Excerpt
	register_rest_field( 'post',
		'excerpt_pst',
		array(
			'get_callback'		=> 'RBTM_RelPost_get_excerpt_pst',
			'update_callback'	=> null,
			'schema'		=> null
		)
	);
        // Add Excerpt
	register_rest_field( 'post',
		'show_my_obj',
		array(
			'get_callback'		=> 'RBTM_RelPost_get_show_my_obj',
			'update_callback'	=> null,
			'schema'		=> null
		)
	);

}

function RBTM_RelPost_get_author_name( $object, $field_name, $request ) {
	return get_the_author_meta( 'display_name' );
}

function RBTM_RelPost_get_image_src( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src( $object[ 'featured_media' ], 'thumbnail', false );
	return $feat_img_array[0];
}

function RBTM_RelPost_get_excerpt_pst( $object, $field_name, $request ) {
	return $object['excerpt']['raw'];
}
function RBTM_RelPost_get_show_my_obj( $object, $field_name, $request ) {
	return $object;
}

add_action( 'rest_api_init', 'RBTM_RelPost_register_fields');



/**
 * Create JSON Route for the WP-API:
 * - Get current post ID
 * - Get IDs of current categories
 * - Create arguments array for categories and posts-per-page
 * - Create the Route
 */
function RBTM_RelPost_get_json_query() {

    // Get all the categories applied to the current post
    $cats = get_the_category();

    // Make an array of the categories
    $cat_ids = array();

    // Loop through each of the categories and grab just the ID
    foreach ($cats as $cat) {
        $cat_ids[] = $cat->term_id;
    }

    // Set up the query variables for category IDs and posts per page
    // e.g. categories=17,18,1&per_page=4&_embed=true
    $args = array(
           'categories' => implode(",", $cat_ids),
           'per_page' => 4,
           '_embed' => "true"
          // categories=17,18,1&per_page=4&_embed=true
    );

    // Stitch everything together in a URL
    $url = add_query_arg( $args, rest_url( 'wp/v2/posts') );

    return $url;

}



// Hook in all the important things
function RBTM_RelPost_scripts() {
	if( is_single() && is_main_query() ) {
    // Get plugin stylesheet
		wp_enqueue_style( 'relpost-styles', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '0.1', 'all' );
		wp_enqueue_script( 'relpost-script', plugin_dir_url( __FILE__ ) . 'js/relpost.ajax.js', array('jquery'), '0.1', true );

		// Get the current post ID
		global $post;
		$post_id = $post->ID;

		// Use wp_localize_script to pass values to relpost.ajax.js
		wp_localize_script( 'relpost-script', 'postdata',
			array(
				'post_id' => $post_id,
				'json_url' => RBTM_RelPost_get_json_query()
			)
		);

	}
}
add_action( 'wp_enqueue_scripts', 'RBTM_RelPost_scripts' );


//----------------------------------- the_content filter ---------------
// Base HTML to be added to the bottom of a post
function RBTM_RelPost_baseline_html() {
	// Set up container etc
	$baseline  = '<section id="related-posts" class="related-posts">';
	$baseline .= '<a href="#" class="get-related-posts">Get related posts</a>';
 	$baseline .= '<div class="ajax-loader"><img src="' . plugin_dir_url( __FILE__ ) . 'css/spinner.svg" width="32" height="32" /></div>';
	$baseline .= '</section><!-- .related-posts -->';

	return $baseline;
}

// Bootstrap this whole thing onto the bottom of single posts
function RBTM_RelPost_display($content){
	if( is_single() && is_main_query() ) {
	    $content .= RBTM_RelPost_baseline_html();
	}
	return $content;
}
add_filter('the_content','RBTM_RelPost_display');
//---------------------------------- the_content filter ---------------
