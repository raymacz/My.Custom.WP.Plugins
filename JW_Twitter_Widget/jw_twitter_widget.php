<?php

error_reporting(E_ALL); //during developement, add this to help in making WP plugins
/**
* Plugin Name: JW_Twitter_Widget
* Description: Displays any Cache Tweets.
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: jw
* License: GPL2+
*
*/
/*

// 306 - Registering the Twitter Widget to 308 - Querying the Twitter API


Class JW_Twitter_Widget extends WP_Widget{ 
	
	function __construct() { //constructors method run immediately when its instantiated
	
		$options = array(
			'description' => 'Displays messages to readers',
			'name' => 'Twitter Widget'
		);
		parent::__construct('JW_Twitter_Widget','', $options); // https://developer.wordpress.org/reference/classes/wp_widget/__construct/
		
	}	
	
	public function form($instance) { // https://developer.wordpress.org/reference/classes/wp_widget/form/ 
		//print_r($instance); 
		extract($instance); //extract from array to variable
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"> Title: </label>		 <!--unique ID & no conflict -->
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
				   name="<?php echo $this->get_field_name('title'); ?>"
				   value="<?php if (isset($title)) echo esc_attr($title); ?>" />  <!-- $title comes from extract() of $instance -->
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"> Twitter Username: </label>		 <!--specifiy a username for twitter -->
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" 
				   name="<?php echo $this->get_field_name('username'); ?>"
				   value="<?php if (isset($username)) echo esc_attr($username); ?>" />  
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('tweet_count'); ?>"> # of Tweets to Retrieve: </label>		 <!--unique ID & no conflict -->
			<input type="number" class="widefat" style="width: 50px" id="<?php echo $this->get_field_id('tweet_count'); ?>" 
				   name="<?php echo $this->get_field_name('tweet_count'); ?>"
				   min="1" max="10"				   
				   value="<?php echo !empty($tweet_count) ? $tweet_count : 5; ?>" />  <!-- 5 is default if empty --> <!-- type="number" - html5 digit only -->
		</p>
		
		<?php
		
	}
	
	public function widget($args, $instance) {//  https://developer.wordpress.org/reference/classes/wp_widget/widget/
		//print_r($args);die(); // prints the display value in a page or post 
		//print_r($instance); // displays the value inputted in the form
		extract($args); // extract from array to variable
		extract($instance);
		
		if (empty($title)) $title = 'Recent Tweets';
		$data = $this->twitter($tweet_count, $username);
		//print_r($data);
	}	
	
	private function twitter($tweet_count, $username){
		if (empty($username)) return false;
		return $this->fetch_tweets($tweet_count, $username);
	}
	
	private function fetch_tweets($tweet_count, $username){
		$tweets = wp_remote_get("http://127.0.0.1:1337/$username"); //WP function that gets json
		$tweets = json_decode($tweets['body']); 
		if (isset($tweets->error)) return false; // json-decode will return error
		$tweets =$tweets->Object->results; //print_r($tweets);
		//print_r($tweets);
		foreach ($tweets as $tweet) {
			if ($tweet_count-- === 0) break; //break out of the loop if the tweets has reach the max limit to display.
				///$data[] = $tweet->Object->results[0]->text;	
			$data[] = $tweet->text;	//place all data into a new array ($data)
		}
		print_r($data);
		
		
		//return $tweets;
	}
*/

///309 - Regular Expressions	
	

Class JW_Twitter_Widget extends WP_Widget{ 
	
	function __construct() { //constructors method run immediately when its instantiated
	
		$options = array(
			'description' => 'Displays messages to readers',
			'name' => 'Twitter Widget'
		);
		parent::__construct('JW_Twitter_Widget','', $options); // https://developer.wordpress.org/reference/classes/wp_widget/__construct/
		
	}	
	
	public function form($instance) { // https://developer.wordpress.org/reference/classes/wp_widget/form/ 
		//print_r($instance); 
		extract($instance); //extract from array to variable
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"> Title: </label>		 <!--unique ID & no conflict -->
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
				   name="<?php echo $this->get_field_name('title'); ?>"
				   value="<?php if (isset($title)) echo esc_attr($title); ?>" />  <!-- $title comes from extract() of $instance -->
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"> Twitter Username: </label>		 <!--specifiy a username for twitter -->
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" 
				   name="<?php echo $this->get_field_name('username'); ?>"
				   value="<?php if (isset($username)) echo esc_attr($username); ?>" />  
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id('tweet_count'); ?>"> # of Tweets to Retrieve: </label>		 <!--unique ID & no conflict -->
			<input type="number" class="widefat" style="width: 50px" id="<?php echo $this->get_field_id('tweet_count'); ?>" 
				   name="<?php echo $this->get_field_name('tweet_count'); ?>"
				   min="1" max="10"				   
				   value="<?php echo !empty($tweet_count) ? $tweet_count : 5; ?>" />  <!-- 5 is default if empty --> <!-- type="number" - html5 digit only -->
		</p>
		
		<?php
		
	}
	
	public function widget($args, $instance) {//  https://developer.wordpress.org/reference/classes/wp_widget/widget/
		//print_r($args);die(); // prints the display value in a page or post 
		//print_r($instance); // displays the value inputted in the form
		extract($args); // extract from array to variable
		extract($instance);
		
		if (empty($title)) $title = 'Recent Tweets';
		$data = $this->twitter($tweet_count, $username); // $data - cached data or new data 
		//print_r($data);die();
		if (false !== $data && isset($data->tweets)) {
		  echo $before_widget;	// $args
			echo $before_title;
				echo $title;
			echo $after_title;
			echo '<ul><li>'.implode('</li><li>', $data->tweets).'</li><ul>'; //implode -array into a string	 // turns foreach into a 1line
		  echo $after_widget;	// $args
		}
	}	
	
	private function twitter($tweet_count, $username){
		if (empty($username)) return false;
		$tweets = get_transient('recent_tweets_widget'); //  WP Transients API - retrieve cached data from database
		
		if (!$tweets || $tweets->username !== $username || $tweets->tweet_count !== $tweet_count) {  // if there are any changes in the form then proceed with a new fetch
		   // if none is cached in WP, fetch manualy from the API
		  //echo $tweet_count;die();
		  return $this->fetch_tweets($tweet_count, $username);
		} 
		return $tweets; // return data whether cached or new fetch
	}
	
	private function fetch_tweets($tweet_count, $username){
		$tweets = wp_remote_get("http://127.0.0.1:1337/$username"); //WP function that gets json
		if (isset($tweets->error)) return false; //moved here coz of wp error
		$tweets = json_decode($tweets['body']); 
		//if (isset($tweets->error)) return false; // json-decode will return error
		
		$tweets =$tweets->Object->results; 
		//print_r($tweets);
		
		$data = new stdClass(); // create a new class $data
		$data->username = $username;
		$data->tweet_count = $tweet_count;
		$data->tweets = array();
		
		foreach ($tweets as $tweet) {
			if ($tweet_count-- === 0) break; //break out of the loop if the tweets has reach the max limit to display.
				///$data[] = $tweet->Object->results[0]->text;	
			$data->tweets[] = $this->filter_tweet($tweet->text);	//place all data into a new array ($data)
		}
		// cache in the database using WP transient
		set_transient('recent_tweets_widget', $data, 60 * 5); // saved 5min in dtabase & will be deleted/expire following another request
		//  WP Transients API - allows to set expiration dates. Cache by storing in the database
		//recent_tweets_widget - ID associated int the database, $data - (username & tweet_count)
		//print_r($data);die();
		return $data;
		
		
	}
	
	private function filter_tweet($tweet) {
		$tweet = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $tweet); // replace urls with <a href>  (found in the string)
		$tweet = preg_replace('/(@[^\s]+)/i', '<i> $1</i>', $tweet); // replace urls with <a href>  (found in the string)
		return $tweet;
				/// /http/ - string of http
				/// [^\s] - any character w/ no space
				/// + - one or more chars
				/// i - uppercase/lowercase
				/// m - search multiple lines
				/// e.g. http://test.mqsssit.ml
				/// (wrapped) - $1   -->> wrapped with parentheses
	}	
	
	
}




add_action('widgets_init', 'register_jw_twitter_widget');

function register_jw_twitter_widget() {
	register_widget('JW_Twitter_Widget'); // Messager Object Instance is passed.
}	

?>
