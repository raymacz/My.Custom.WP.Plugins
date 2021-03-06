<?php
/**
* Plugin Name: WP Class Sandbox
* Description: Sandbox for Wordpress Classes API
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:webmacz.ml
* Text Domain: rbtm
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

        public static function funcstatic($param) {
            return $param.' method!!!';
        }
        
        public function getstatic() {
            echo "from an INSTANCE method to a".self::funcstatic('STATIC');
        }
}




$obj = new MyHeight;
//$obj->executes();

add_action('in_the_middle_next_action', array('MyHeight','executes_two')); //executes a static function
do_action('in_the_middle_next_action'); // executes both using Class & direct call
$obj->executes_do();

//echo '<pre>'.$obj->top().' aaaaaaaaaaaaaaaaaaaaaaaaaaa</pre>';


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



?>
