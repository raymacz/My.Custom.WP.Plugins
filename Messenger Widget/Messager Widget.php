<?php

error_reporting(E_ALL); //during developement, add this to help in making WP plugins
/**
* Plugin Name: Messager Widget
* Description: Displays any messages designated.
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: cwpl
* License: GPL2+
*
*/

// 03 - The Skin for a Widget

Class Messager extends WP_Widget{ 
	
	function __construct() { //constructors method run immediately when its instantiated
	
		$options = array(
			'description' => 'Displays messages to readers',
			'name' => 'Messager'
		);
		parent::__construct('Messager','', $options); // https://developer.wordpress.org/reference/classes/wp_widget/__construct/
		
	}	
	
	public function form($instance) { // https://developer.wordpress.org/reference/classes/wp_widget/form/ // any <input> in the widget like the title input are added in the form method
		//print_r($instance); 
		extract($instance); //extract - gets values from an array and convert it to variables.
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"> Title: </label>
			 <!--unique ID & no conflict -->
			 <!--wordpress class to beautify <input> -->
			 <!-- constructs id attributes for use in WP_Widget::form() fields. -->
			<input class="widefat" 
				   id="<?php echo $this->get_field_id('title'); ?>" 
				   name="<?php echo $this->get_field_name('title'); ?>"
				   value="<?php if (isset($title)) echo esc_attr($title); ?>" />  <!-- $title comes from extract() of $instance -->
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"> Description: </label>
			 <!--unique ID & no conflict -->
			<textarea class="widefat" 
					  rows="10"
					  id="<?php echo $this->get_field_id('description'); ?>" 
					  name="<?php echo $this->get_field_name('description'); ?>" ><?php if (isset($description)) print esc_attr($description); ?></textarea>		   <!-- $description comes from extract() of $instance -->
		</p>

		
		<?php // widefat - class available in wordpress for nice input style
		
		
	}
	
	public function widget($args, $instance) {//  https://developer.wordpress.org/reference/classes/wp_widget/widget/
		//print_r($args); // prints the display value in a page or post  (e.g. before_title, widget_it, widget_name)
		//print_r($instance); // displays the value inputted in the form
		extract($args);
		extract($instance);
		
		// WP default filtering
		$title = apply_filters('widget_title',$title);
			 // - tip: $title = apply_filters('widget_title',$title); // widget_title can also be found in the WP Class Widget (e.g <H3 class="widget-title">
			 //https://developer.wordpress.org/reference/hooks/widget_title/
		$description = apply_filters('widget_title',$description);
		
		$title = apply_filters('widget_title', $title);
		$description = apply_filters('widget_description', $description);
		
		if (empty ($title)) $title  = 'Default Title'; // set default title if its empty
		
		echo $before_widget;
			echo $before_title. $title. $after_title;
			echo "<p>$description</p>"; //must be in double quotes for variable to display its value
		echo $after_widget;	 
	}	
}


add_action('widgets_init', 'jw_register_messager');

function jw_register_messager() {
	register_widget('Messager'); // Messager Object Instance is passed.
}	

?>