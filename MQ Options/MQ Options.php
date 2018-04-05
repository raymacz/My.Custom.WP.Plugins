<?php

//error_reporting(E_ALL); //during developement, add this to help in making WP plugins
/**
* Plugin Name: JW Options
* Description: Options page for a theme
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: jw
* License: GPL2+
*
*/

class jw_Options {
	
		public $options; 
		
		public function __construct() 
		{	
			//delete_option('jw_plugin_options'); // set on & off this code to reset testing
			$this->options = get_option('jw_plugin_options'); // jw_plugin_options - is already available because we registered the new option setting
			/*
					$z = get_option('jw_plugin_options');
					echo '<pre>get_option_top: ';
					print_r($z);
					//echo $o['jw_banner_heading'];
					echo '</pre>'; */
				
			$this->register_settings_and_fields();
		}
		
		//public function add_menu_page() 
		public static function add_menu_page() 
		{
			add_options_page('Theme options', 'Theme Options', 'administrator', __FILE__, array('jw_Options', 'display_options_page'));// jw_Options - if using static
			// Theme options - page title, 'Theme Options'- menu title, 'administrator' - capability,  __FILE__ - menu_slug, ('jw_Options', 'display_options_page') - array & callback
			// create an option page
			// some developers use __FILE__ for unique ID - https://www.screencast.com/t/vTtDK4SEsEH
			// if add_options_page is not wrapped, it will get an error & it will run on all pages
		}	
		
		// public function display_options_page() // display the page
		public static function display_options_page() // display the page
		{
			?>
			<div class="wrap"> 
				<!-- screen_icon(); //deprecated -->
				
				
				<h2>My Theme Options</h2>
				<!-- enctype="multipart/form-data" --- ability to upload data to any php <form> -->
					<!-- options.php created by WP -->
				
				<?php
					$o = get_option('jw_plugin_options');
					echo '<pre>get_option';
					print_r($o);
					//echo $o['jw_banner_heading'];
					echo '</pre>';
				?>
				
					
				<form method="post" action="options.php" enctype="multipart/form-data"> 
					<?php settings_fields('jw_plugin_options');
					//  WP adds hidden <inputs> for security
					do_settings_sections(__FILE__);
					//filter all functions & where to display the fields
					?>
					<p class="submit">  <!-- style submit by WP   -->
						<input name="submit" type="submit" class="button-primary" value="Save Changes" />
						<!-- tip: Browse/Inspect WP admin pages to get the CSS Styles or other element attributes -->
					</p>
				</form>
			</div>
			
			<?php
		}
		
		public function register_settings_and_fields()
		{
			//register_setting('jw_plugin_options', 'jw_plugin_options', array($this,'jw_validate_settings')); //3rd param - optional
			register_setting('jw_plugin_options', 'jw_plugin_options', array($this,'jw_validate_settings')); //3rd param - optional
			//get_options('jw_plugin_options');
			add_settings_section('jw_main_section', 'Main Settings', array($this,'jw_main_section_cb'), __FILE__); //one section for this project
			//id, display title, callback, related page_slug // add_settings_section, more like a container for <inputs>
			add_settings_field('jw_banner_heading', 'Banner Heading: ', array($this, 'jw_banner_heading_setting_cb'), __FILE__, 'jw_main_section'); 
			add_settings_field('jw_logo', 'Upload Logo: ', array($this, 'jw_logo_setting_cb'), __FILE__, 'jw_main_section'); 
			add_settings_field('jw_color_scheme', 'Color Scheme: ', array($this, 'jw_color_scheme_setting_cb'), __FILE__, 'jw_main_section'); 
		}	//id, display title, callback, related page_slug, callback, section id 
		
			/*
			** Field <inputs>
			*/
		
		public function jw_main_section_cb() 
		{
			//	optional
		}
		
		public function jw_color_scheme_setting_cb() 
		{
			//	optional
			$items= array('red','blue','white','yellow','green');
			echo "<select name='jw_plugin_options[jw_color_scheme]' >";
			//echo "<select name='jw_plugin_options' >";
			foreach($items as $item) {
				$selected= ($this->options['jw_color_scheme'] === $item) ? 'selected="selected"': '' ; // set selected as default
				 echo "<option value='$item' $selected>$item</option>";	
			}	
			echo "</select>";
		}
		
		public function jw_validate_settings($plugin_options) 
		{  //Is this file an image?
		//	print_r($_FILES);//die();  ///prints file info array php global 
			if (!empty($_FILES['jw_logo_upload']['tmp_name'])) { // check if file is upload
				$override=array('test_form'=>false);
				$file = wp_handle_upload($_FILES['jw_logo_upload'], $override);	 // results will be uploaded
				$plugin_options['jw_logo'] = $file['url']; //path/url of logo
			} else {
				$plugin_options['jw_logo'] = $this->options['jw_logo'];
			}				
			return $plugin_options;
		}
			
		public function jw_banner_heading_setting_cb() // display input Banner Heading
		{
			echo "<input name='jw_plugin_options[jw_banner_heading]' type='text' value='{$this->options['jw_banner_heading']}' />";  // jw_plugin_options - use as name to associate with register_setting
			//echo '<input name="jw_plugin_options[jw_banner_heading]" type="text" value="{$this->options['jw_banner_heading']}"/>'; 
			// jw_plugin_options - use as name to associate with register_setting
		}
		
		public function jw_logo_setting_cb() // display input Banner Heading
		{
			//echo '<input type="file"/>';
			
			$pic = $this->options['jw_logo'];
			echo '<input type="file" name="jw_logo_upload" /><br /><br />';
		//	echo '<input type="file" name="jw_plugin_options[jw_logo]" /><br /><br />';
			if (isset($this->options['jw_logo'])) {
				echo "<img src='{$this->options['jw_logo']}' alt='' />";
				//echo "<img src='".$pic."' alt='' />";
			}	
		}
}

add_action('admin_menu', function(){ //admin menu loads
	jw_Options::add_menu_page();
});	

add_action('admin_init', function() {
	 new jw_Options(); // new instance
}); // if possible always use anonymous functions in plugins


?>