<?php
/**
* Plugin Name: Action & Filter Hooks
* Description: Sandbox for Action & Filter Hooks
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: aafh
* License: GPL2+
*
*/

/*
*  Filter vs Action
*
*  In add_action, you can stackup actions
*  (e.g. display multiple get_sidebar( 'footer' ) & get_sidebar( 'credits' ) &  	echo "\r\n\r\n" )
*  display multiple actions by do_action
*
*  In add_filter( 'walker_nav_menu_start_el', changes in different parts of the template or menu e.g. Primary Menu
*  Menu item modification: submenu expander
*  Menu item modification: item description
*
*  In add_filter( 'post_class'
*		Set/modify a generic class for easy styling
*  // Condensed posts - remove/modify format classes depending on the current template
*
*/

 // #24 if this file is called directly, abort
if ( !defined('ABSPATH')) {
	die;
}


class MyHeight {

	public function __construct() {
	        add_action( 'in_the_middle_next_action', array( $this, 'executes' ) );
	 }


	public function top() {
	  return apply_filters('top_text', 'This is the top!');
	  //return 'This is the top!!!xyz';
	}

	public function callbackz() {
	  return 'x changed!!!AAAAA';
	}

	function abovve() {
	  return 'This is the above!';
			  //return 'This is the top!!!xyz';
	}

	public static function bottom() {
	 return 'This is the bottom!!!';
	}

	static function beneath() {
	 return 'This is the beneath!!!';
	}

	public function executes() {

		echo '<br>';
		echo '<br>';
		echo '<pre>This is the middle '.self::beneath().'..</pre>';
		echo '<pre>This is the middle this. use constructor class '.$this->abovve().'..</pre>';

	}

	public function executes_two() {

		echo '<br>';
		echo '<br>';
		echo '<pre>This is the middle. Direct call '.self::beneath().'..</pre>';

	}

	public function executes_do() {
		echo "direct class call for do_action";
		do_action('in_the_middle_next_action');
	}

}




$obj = new MyHeight;
//$obj->executes();

add_action('in_the_middle_next_action', array('MyHeight','executes_two')); //executes a static function
do_action('in_the_middle_next_action'); // executes both using Class & direct call
$obj->executes_do();

//echo '<pre>'.$obj->top().' aaaaaaaaaaaaaaaaaaaaaaaaaaa</pre>';
//echo '<pre>'.do_action('in_the_middle').'</pre>';

echo MyHeight::bottom().'</pre>';
//$obj->callbackz();


function changetext() {
	return 'hayzzzzzzzzzzzzzz';
}

/*
function adfilter() {
	 return add_filter('top_text', array('MyHeight','callbackz'));
	 return 'crappppppppppppppp';
}
*/

add_filter('top_text','changetext'); // 'hayzzzzzzzzzzzzzz'
add_filter('top_text', array($obj, 'callbackz')); // 'x changed!!!AAAAA'

echo '<pre>bbbzzz '.$obj->top().'</pre>';



function aafh_login_stylesheet() {
	//register & load to queue the new added stylesheet
	wp_register_style('aafh_custom_stylesheet', plugin_dir_url( __FILE__ ).'css/login-style.css');
	wp_enqueue_style('aafh_custom_stylesheet');

}

// hook the function before the scripts are loaded in WP login page
add_action('login_enqueue_scripts', 'aafh_login_stylesheet');


function aafh_login_error_msg($errors) {
	//override errors
	return  'Invalid Credentials';
}

 //if (has_filters('login_errors', 'aafh_check_error')) {
	add_filter( 'login_errors', 'aafh_login_error_msg', 1);
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
  echo '<pre>This is the middle something..zz</pre>';
}


add_action('in_the_middle', 'something'); // - note (very IMPORTANT): add_action() should be first before do_action() unlike apply_filters() & add_filter();
//add_action('in_the_middle_next_action', array('MyHeight','executes'));

///



//echo '<pre>'.do_action('in_the_middle').'</pre>';
do_action('in_the_middle');


// #24 Setting up the folder and file structure single-post-content-plus.php ----------------

function aafh_login_stylesheet24() {
	//let other developers add a filter to load/unload the styles #27 Applying filters for loading stylesheets
	if (apply_filters('aafh_load_stylez', true)) {
		//register & load to queue the newly added stylesheet
		if ( is_single() && is_main_query() ) { // styles only applied only on single post
			wp_enqueue_style('aafh_custom_stylesheet24', plugin_dir_url( __FILE__ ).'css/login-style24.css');
		}
	}
}

// whether to load plugin styles #27 Applying filters for loading stylesheets
add_filter('aafh_load_stylez', '__return_true');
//add_filter('aafh_load_stylez', '__return_false');

//register & load to queue the newly added stylesheet (not login stylesheet)
add_action('wp_enqueue_scripts','aafh_login_stylesheet24');


// #25 Registering a sidebar
function aafh_register_sidebar() {
	//register & load to queue the new added stylesheet
	register_sidebar ( array(
		'name'          => esc_html__( 'Post Content Plus', 'boot2wp' ),
		'id'            => 'aafh_sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'boot2wp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s aafh-sidebar">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title aafh-title">',
		'after_title'   => '</h3>',

	));
}

add_action('widgets_init', 'aafh_register_sidebar');


//NOTE::: #26 Displaying a sidebar on SINGLE POST
function aafh_display_sidebar( $content ) {
 //display sidebar


  if ( is_active_sidebar('aafh_sidebar') && is_single() && in_the_loop() && is_main_query() ) {
	$content = $content."testme ";
	dynamic_sidebar('aafh_sidebar');
    return $content . "I'm filtering the content inside the main loop";
  }

 return $content;
}

//display sidebar on single post
add_filter('the_content', 'aafh_display_sidebar');






?>
