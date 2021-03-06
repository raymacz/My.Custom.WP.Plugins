<?php
/**
* Plugin Name: MQ Options
* Description: Options page for a theme using the Settings API
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:webmacz.ml
* Text Domain: jw
* License: GPL2+
*
*/

error_reporting(E_ALL); //during developement, add this to help in making WP plugins

class mq_Options {
	
		public $options;  // this propery is used to display back the value to the form
		
		public function __construct() 
		{	
//			delete_option('mq_plugin_options'); // set on & off this code to reset/delete your saved setting for testing
			$this->options = get_option('mq_plugin_options'); // get the inputted section/fields value from database data based from register_setting('mq_plugin_options')
                        //IMPORTANT: refer to options.php once you have used registered_setting() // https://www.screencast.com/t/HtP3bNAEi
			/*
					$z = get_option('mq_plugin_options');
					echo '<pre>get_option_top: ';
					print_r($z);
					//echo $o['mq_banner_heading'];
					echo '</pre>'; */
				
			$this->register_settings_and_fields();
		}
		
		//public function add_menu_page() 
		public static function add_menu_page() 
		{
			add_options_page('Theme options', 'Theme Options', 'administrator', __FILE__, array('mq_Options', 'display_options_page'));// mq_Options - if using static //$this - if instance
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
				<?php // this will test if the inputted value is already added to WP
					$o = get_option('mq_plugin_options');
					echo '<pre>get_option'; print_r($o); echo '</pre>';
				?>
				 <!--https://stackoverflow.com/questions/4526273/what-does-enctype-multipart-form-data-mean-->
				<form method="post" action="options.php" enctype="multipart/form-data">  
					<?php settings_fields('mq_plugin_options');//  WP adds hidden <inputs> for security
					do_settings_sections(__FILE__); 	//filter all functions & where to display the fields
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
			register_setting('mq_plugin_options', 'mq_plugin_options', array($this,'mq_validate_settings')); //3rd param - optional
//			  register_setting('mq_plugin_options', 'mq_plugin_options', $args); //$args not really working maybe on file upload
			add_settings_section('mq_main_section', 'Main Settings', array($this,'mq_main_section_cb'), __FILE__); //one section for this project
			add_settings_field('mq_banner_heading', 'Banner Heading: ', array($this, 'mq_banner_heading_setting_cb'), __FILE__, 'mq_main_section'); 
			add_settings_field('mq_logo', 'Upload Logo: ', array($this, 'mq_logo_setting_cb'), __FILE__, 'mq_main_section'); 
			add_settings_field('mq_color_scheme', 'Color Scheme: ', array($this, 'mq_color_scheme_setting_cb'), __FILE__, 'mq_main_section'); 
		}	

                public function mq_main_section_cb($tester) 
		{
			//	optional
//                     echo "<pre>mq_main: ";      print_r($tester); echo "</pre>";
		}
		
		public function mq_color_scheme_setting_cb() 
		{
			//	optional
			$items= array('red','blue','white','yellow','green');
			echo "<select name='mq_plugin_options[mq_color_scheme]' >";
			//echo "<select name='mq_plugin_options' >";
			foreach($items as $item) {
				$selected= ($this->options['mq_color_scheme'] === $item) ? 'selected="selected"': '' ; // set selected as default
				 echo "<option value='$item' $selected>$item</option>";	
			}	
			echo "</select>";
		}
		
		public function mq_validate_settings($plugin_options) 
		{ 
//                      echo "<pre>mq_validate ";      print_r($plugin_options); echo "</pre>"; 
		//	print_r($_FILES);//die();  ///prints file info array - php global 
			if (!empty($_FILES['mq_logo_upload']['tmp_name']) && ($_FILES['mq_logo_upload']['name'] === sanitize_file_name($_FILES['mq_logo_upload']['name'])) ) { // check if file is upload
				$overrides=array('test_form'=>false); // 'test_form' should be the array key or it won't work
				$file = wp_handle_upload($_FILES['mq_logo_upload'], $overrides);	 // results will be uploaded
				$plugin_options['mq_logo'] = $file['url']; //path/url of logo
//                                $filez = sanitize_file_name($_FILES['mq_logo_upload']['name']);
			} else {
				$plugin_options['mq_logo'] = $this->options['mq_logo']; //??? not clear as to what purpose of Jeff
			}	
//                        die();
			return $plugin_options;
		}
			
		public function mq_banner_heading_setting_cb() // display input Banner Heading
		{
			echo "<input name='mq_plugin_options[mq_banner_heading]' type='text' value='{$this->options['mq_banner_heading']}' />";  // mq_plugin_options - use as name to associate with register_setting
			//echo '<input name="mq_plugin_options[mq_banner_heading]" type="text" value="{$this->options['mq_banner_heading']}"/>'; 
			// mq_plugin_options - use as name to associate with register_setting
		}
		
		public function mq_logo_setting_cb() // display input Banner Heading
		{
			//echo '<input type="file"/>';
			$pic = $this->options['mq_logo'];
			echo '<input type="file" name="mq_logo_upload" /><br /><br />';
		//	echo '<input type="file" name="mq_plugin_options[mq_logo]" /><br /><br />';
			if (isset($this->options['mq_logo'])) {
				echo "<img src='{$this->options['mq_logo']}' alt='' />";
				//echo "<img src='".$pic."' alt='' />";
			}	
		}
}
add_action('admin_init', function() {
	 new mq_Options(); // new instance of the form
}); // if possible always use anonymous functions in plugins

add_action('admin_menu', function(){ //display admin menu when it loads
	mq_Options::add_menu_page();
});	



?>