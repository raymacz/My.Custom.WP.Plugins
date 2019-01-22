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



class RBTM_RelPost {
    
    public $myID;
    
    // Add various fields to the JSON output
    public function __construct() {
        $this->RP_scripts();
        $this->RP_register_fields();
    }
    
    public function RP_get_author_name( $object, $field_name, $request ) {
	return get_the_author_meta( 'display_name' );
    }

    public function RP_get_image_src( $object, $field_name, $request ) {
	$feat_img_array = wp_get_attachment_image_src( $object[ 'featured_media' ], 'thumbnail', false );
	return $feat_img_array[0];
    }

    public function RP_get_excerpt_pst( $object, $field_name, $request ) {
	return $object['excerpt']['raw'];
    }
    
    public function RP_get_show_my_obj( $object, $field_name, $request ) {
	return $object;
    }

    
    public function RP_register_fields() {
        add_action( 'rest_api_init', function() {
            // Add Author Name
           register_rest_field( 'post',
                   'author_name',
                   array(
                           'get_callback'	=> array($this, 'RP_get_author_name'),
                           'update_callback'	=> null,
                           'schema'		=> null
                   )
           );

           // Add Featured Image
           register_rest_field( 'post',
                   'featured_image_src',
                   array(
                           'get_callback'	=> array($this, 'RP_get_image_src'),
                           'update_callback'	=> null,
                           'schema'		=> null
                   )
           );

           // Add Excerpt
           register_rest_field( 'post',
                   'excerpt_pst',
                   array(
                           'get_callback'	=> array($this,'RP_get_excerpt_pst'),
                           'update_callback'	=> null,
                           'schema'		=> null
                   )
           );
           // Add Excerpt
           register_rest_field( 'post',
                   'show_my_obj',
                   array(
                           'get_callback'	=> array($this,'RP_get_show_my_obj'),
                           'update_callback'	=> null,
                           'schema'		=> null
                   )
           );
        });   
        
	

    }
    
    
    public function RP_get_json_query() {

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
    
    
    public function RP_scripts() {
        
        add_action('wp_enqueue_scripts', function() {
            
            if( is_single() && is_main_query() ) {
              // Get plugin stylesheet
                wp_enqueue_style( 'relpost-styles', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '0.1', 'all' );
                wp_enqueue_script( 'relpost-script', plugin_dir_url( __FILE__ ) . 'js/relpost.ajax.js', array('jquery'), '0.1', true );
            }
            
                // Get the current post ID
		global $post;
		$this->myID = $post->ID;

		// Use wp_localize_script to pass values to relpost.ajax.js
		wp_localize_script( 'relpost-script', 'postdata',
			array(
				'post_id' => $this->myID,
				'json_url' => $this->RP_get_json_query()
			)
		);
            
        });
    }
    
    
    public static function RP_baseline_html() {
	// Set up container etc
	$baseline  = '<section id="related-posts" class="related-posts">';
	$baseline .= '<a href="#" class="get-related-posts">Get related posts</a>';
 	$baseline .= '<div class="ajax-loader"><img src="' . plugin_dir_url( __FILE__ ) . 'css/spinner.svg" width="32" height="32" /></div>';
	$baseline .= '</section><!-- .related-posts -->';

	return $baseline;
//        return "rbtm baseline";
    }
    
    public static function RP_display($content){
	if( is_single() && is_main_query() ) {
	    $content .= self::RP_baseline_html();
	}
	return $content;
    }
}



add_action('init', function() {
	new RBTM_RelPost();
});

add_filter('the_content', array('RBTM_RelPost', 'RP_display'));