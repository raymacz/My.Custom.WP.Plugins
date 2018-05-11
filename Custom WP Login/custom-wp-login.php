<?php
/**
* Plugin Name: Custom WP Login
* Description: Action & Filter Hooks 
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: cwpl
* License: GPL2+
*
*/

 // #24 if this file is called directly, abort
if ( !defined('ABSPATH')) {
	die;
}

function cwpl_login_stylesheet() {
	//register & load to queue the new added stylesheet
	wp_register_style('cwpl_custom_stylesheet', plugin_dir_url( __FILE__ ).'css/login-style.css');
	wp_enqueue_style('cwpl_custom_stylesheet');
	
}

// hook the function before the scripts are loaded in WP login page
add_action('login_enqueue_scripts', 'cwpl_login_stylesheet');


function cwpl_login_error_msg($errors) {
	//override errors	
	return  'Invalid Credentials';
}

 //if (has_filters('login_errors', 'cwpl_check_error')) {
	add_filter( 'login_errors', 'cwpl_login_error_msg', 1);
	//add_filter( 'login_errors', _return_null); // you can return w/ no messages
 //}
 
// removes the javascript shake in login page	
function remove_shake() {
 if (has_action( 'login_head', 'wp_shake_js')) :	
	remove_action('login_head', 'wp_shake_js', 12 );
 endif;	
}
add_action('login_head', 'remove_shake');

function something() {
   //return 'This is the middle..';	 // - note: a function with RETURN won't work in do_action() / add_action()
  echo '<pre>This is the middle something..</pre>';	
}

add_action('in_the_middle', 'something'); // - note (very IMPORTANT): add_action() should be first before do_action() unlike apply_filters() & add_filter();
//add_action('in_the_middle_next', array('MyHeight','executes')); 

//echo '<pre>'.do_action('in_the_middle').'</pre>';
do_action('in_the_middle');

// #24 Setting up the folder and file structure single-post-content-plus.php ----------------
function cwpl_login_stylesheet24() {
	//let other developers add a filter to load/unload the styles #27 Applying filters for loading stylesheets
	if (apply_filters('cwpl_load_stylez', true)) {
		//register & load to queue the newly added stylesheet
		if ( is_single() && is_main_query() ) { // styles only applied only on single post
			wp_enqueue_style('cwpl_custom_stylesheet24', plugin_dir_url( __FILE__ ).'css/login-style24.css');
		}
	}
}

// whether to load plugin styles #27 Applying filters for loading stylesheets
add_filter('cwpl_load_stylez', '__return_true');
//add_filter('cwpl_load_stylez', '__return_false');

//register & load to queue the newly added stylesheet (not login stylesheet)
add_action('wp_enqueue_scripts','cwpl_login_stylesheet24');

// #25 Registering a sidebar
function cwpl_register_sidebar() {
	//register & load to queue the new added stylesheet
	register_sidebar ( array(
		'name'          => esc_html__( 'Post Content Plus', 'boot2wp' ),
		'id'            => 'cwpl_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'boot2wp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s cwpl-sidebar">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title cwpl-title">',
		'after_title'   => '</h3>',
	
	));
}

add_action('widgets_init', 'cwpl_register_sidebar');

//NOTE::: #26 Displaying a sidebar on SINGLE POST 
function cwpl_display_sidebar( $content ) {
 //display sidebar
  
  if ( is_active_sidebar('cwpl_sidebar') && is_single() && in_the_loop() && is_main_query() ) {
	$content = $content."testme ";
	dynamic_sidebar('cwpl_sidebar');
    return $content . "I'm filtering the content inside the main loop";
  }
  
 return $content;
}

//display sidebar on single post
add_filter('the_content', 'cwpl_display_sidebar');


//02 - Filter Hooks

add_filter('the_title', ucwords);
	
add_filter('the_title', function ($content) {
	return ucwords($content) .' '. time(); //uppercase the first of each word http://php.net/manual/en/function.ucwords.php
});

//03 - Action Hooks

add_action('wp_footer', function () { // fires when footer is displayed
	echo 'hello from footer'; 
});

add_action('comment_post', function () { // fires when a user post a comment
	echo 'hello from comment'; 
	$email = get_bloginfo('admin_email'); // returng/gets the admin email
	wp_mail($email, 'Subject: New Comment Posted', 'Message: A new comment has been posted!'); //sends email to admin
});

add_filter('the_content', function($content) {
	if (!singular_post('post')) {
		return $content;
	}		
	$id = get_the_ID();
	$terms = get_the_terms($id, 'category'); // gets all the terms of a particular post
	$cats = array();
	//print_r($terms);
	foreach($terms as $term) {
		$cats[] = $term->cat_ID; // https://www.screencast.com/t/FmcXJNoS
	}
	$loop= new WP_Query(
		array(	
			'posts_per_page' => 3,  
			'category__in' => $cats, // hast that category
			'orderby' => 'rand', // random order
			'post__not_in' => array($id) // not to display this post w. this ID
		)	
	);
	
	if ($loop->have_posts()) {
		$content .= '
		 <h2> You Also Might Like.. </h2>
		 <ul class="related-category-posts"></ul>';
		
		while ($loop->have_posts()) {
			$loop->the_posts();	
			$content .= '
				 <li> <a href="'.get_permalink().'">'.get_the_title().'</a>
				 </li>';
		} 
		 
		$content .= '</ul>';
		wp_reset_query(); // good practice to reset query when its done.
	}	
	
	return $content;
});


?>







