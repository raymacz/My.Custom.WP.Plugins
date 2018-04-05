<?php

error_reporting(E_ALL); //during developement, add this to help in making WP plugins
/**
* Plugin Name: Movies Post Type
* Description: Offers a method for managing a movie collection
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: jw
* License: GPL2+
*
*/


class JW_Movies_Post_Type {
	
	public function __construct()
	{	//602 - Registering a New Post Type
		$this->register_post_type();
		$this->taxonomies();
		$this->metaboxes();
	}

	public function register_post_type()
	{
		$args = array(
			'labels' => array( // labels to display
				'name' => 'Movies',
				'singular_name' => 'Movie',
				'add_new' => 'Add New Movie',
				'add_new_item' => 'Add New Movie Item',
				'edit_item' => 'Edit Item',
				'new_item' => 'Add New Item',
				'view_item' => 'View Movie',
				'search_items' => 'Search Movies',
				'not_found' => 'No Movies Found',
				'not_found_in_trash' => 'No Movies Found in Trash',
				
			),
			'query_var' => 'movies',
			'rewrite' => array(
				'slug' => 'movies',
				//'slug' => 'movies/',
			),
			'public' => true,
			//'menu_position' => 25, // (int) where menu is located in the admin
			//603 - Menu Positioning and Custom Icons
			'menu_icon' => admin_url().'images/media-button-video.gif',  ///  F:\Raymacz\xampp\htdocs\wp\site1\wp-admin\images
			'supports' => array(
				'title',
				'thumbnail', //set featured image
				'excerpt',
			//	'custom-fields', //  user can insert their own custom fields
				//'editor',
			)
		);
	/*	echo "<pre>";
			print_r($args);
		echo "</pre>"; */
		register_post_type('jw_movie', $args); 
		
	}
	
	public function taxonomies()
	{
		$taxonomies = array(); // we created an array for genere, actors, etc.
			// genre examples: Science Fiction, Comedy, Drama, Horror, Romance
		$taxonomies['genre'] = array( // genre taxonomies, we can also add actors
			'hierarchical' => true,  // if it can have parent items
			'query_var' => 'movie_genre', 
			'rewrite' => array(
				'slug' => 'movies/genre',
			),
			'labels' => array( // labels to display
				'name' => 'Genres',
				'singular_name' => 'Genre',
				'edit_item' => 'Edit Genre',
				'update_item' => 'Update Genre',
				'add_new_item' => 'Add New Genre Item',
				'new_item_name' => 'New Genre Item Name',
				'all_items' => 'All Genres',
				'search_items' => 'Search Genres',
				'popular_items' => 'Popular Genres',
				'separate_items_with_comments' => 'Separate Genres with commas',
				'add_or_remove_items' => 'add or remove genres',
				'choose_from_most_used' => 'Choose from most used genres',
			),
		); // studio examples: Warner Brothers, Imagine, Marvel Studios, Disney Studios
		$taxonomies['studio'] = array( // genre studio, we can also add actors
			'hierarchical' => true,  // if it can have parent items
			'query_var' => 'movie_studio', 
			'rewrite' => array(
				'slug' => 'movies/studios',
			),
			'labels' => array( // labels to display
				'name' => 'Studios',
				'singular_name' => 'Studio',
				'edit_item' => 'Edit Studio',
				'update_item' => 'Update Studio',
				'add_new_item' => 'Add New Studio Item',
				'new_item_name' => 'New Studio Item Name',
				'all_items' => 'All Studios',
				'search_items' => 'Search Studios',
				'popular_items' => 'Popular Studios',
				'separate_items_with_comments' => 'Separate Studios with commas',
				'add_or_remove_items' => 'add or remove Studios',
				'choose_from_most_used' => 'Choose from most used Studios',
			),
		);	
		
		$this->register_all_taxonomies($taxonomies);
		
	}

	public function register_all_taxonomies($taxonomies) // pair taxonomies w/ main post
	{
		///register_taxonomy('movie_genre', array('jw_movie'),$args); //1st- what movie, 2nd- movie type (object)
		foreach ($taxonomies as $name => $arr) {
			register_taxonomy($name, array('jw_movie'), $arr); //1st- what movie, 2nd- movie type (object), $arr - arguemnts ($args)
		}
	}
	
	public function metaboxes() 
	{
		add_action('add_meta_boxes', function() {	
			// css id, title, cb, assoc. post type/page, priority lvl, cb arg.
			add_meta_box('jw_movie_length', 'Movie Length', 'movie_length', 'jw_movie'); // add new metabox to the post type
			
		});	
			
		function movie_length($post) {
								//  ID property, css id/key, (single or array) (true or false)
			$length = get_post_meta($post->ID, 'jw_movie_length', true); 
			?>	
			<p>
				<label for="jw_movie_length"> Length: </label>
				<input type="text" class= "widefat" name="jw_movie_length" id="jw_movie_length" value="<?php echo esc_attr($length);?>" />
			
			</p>				
			<?php	
		}
		
		add_action('save_post', function($id) {
			if (isset($_POST['jw_movie_length'])) {
				update_post_meta( $id, 'jw_movie_length', strip_tags($_POST['jw_movie_length']) );
			}
		});
			
		
	}
}


add_action('init', function() {
	new JW_Movies_Post_Type();
	include dirname(__FILE__).'/movies_post_type_shortcode.php';
});



?>