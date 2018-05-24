<?php


/**
* Plugin Name: Twitter Shortcode
* Description: Twitter Shower Tutorial
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: cwpl
* License: GPL2+
*
*/

/*
 * general notes: 
 * 1. Run Git Bash
 * 2. cd /f/MyTutorials/MyWork/nodejs/MyCode
 * 3. $ node server.js
 * 4. check in browser url - http://127.0.0.1:1337/products.json
 * 5. F:\MyTutorials\MyWork\nodejs\MyCode\server.js check fs.createReadStream("./jsonsample/products.json").pipe(response);	
 * 6. check tweet_reset_time (in min.)
 * 7. it should work!
 * 
 */



//02 - The add_shortcode Method

/*
add_shortcode('twitter', function(){  // [twitter] - place in post
//	return 'hi'; //when displaying, always return in shortcode not echo...
	return '<a href="http://mqassist.ml"> Click Link </a>'; 
});
*/

// 03 - Attributes

/*
add_shortcode('twitter', function($atts){ 
	/// [twitter  username="myusername" hello=world] - place in post  ->> Array ( [username] => myusername [hello] => world )
	/// quotations are optional w/ condition that value should be one word.
	print_r($atts);die();
//	return 'hi'; //when displaying, always return in shortcode not echo...
	if (!isset($atts['username'])) $atts['username'] ='raymacz'; // set default username
	return '<a href="http://mqassist.ml/'.$atts['username'].'"> Please follow me everybody  </a>'; 
});
*/

/*
//04 - Specifying Content

/// [twitter  username="myusername"] Please follow me everybody [/twitter] - place in post
add_shortcode('twitter', function($atts, $content){ 
	print_r($content);die();
//	return 'hi'; //when displaying, always return in shortcode not echo...
	if (!isset($atts['username']) $atts['username'] ='raymacz'; // set default username
	if (empty($content)) $content ='Please follow'; // set default $content
	return '<a href="http://mqassist.ml/'.$atts['username'].'"> '.$content.' </a>'; 
});
*/


/*
//05 -  The shortcode_atts Function

/// [twitter  username="myusername"] Please follow me everybody [/twitter] - place in post
add_shortcode('twitter', function($atts, $content){ 
	//print_r($atts);die();
//	return 'hi'; //when displaying, always return in shortcode not echo...
	$atts = shortcode_atts(
		array(
			'username' => 'raymacz',
			'content' => !empty($content) ? $content : 'Follow me',
		), $atts
	);
	
	extract($atts);	//extract - gets values from an array and convert it to variables.
	return "<a href='http://mqassist.ml/$username'>$content</a>";  // acceptable variables after extract
});
*/

/*

///06 - Tweets Project - Part 1	
/// [twitter  username="myusername" show_tweets='true'] 



add_shortcode('twitter', function($atts, $content){ 
	//print_r($atts);die();
	$atts = shortcode_atts(
		array(
			'username' => 'raymacz',
			'content' => !empty($content) ? $content : 'Follow me',
			'show_tweets' => false,
			'tweet_reset_time' => 10,
			'num_tweets' => 5,
		), $atts
	);
	
	extract($atts);	//extract - gets values from an array and convert it to variables.
	if ($show_tweets) {
		$tweets= fetch_tweets($num_tweets, $username, $tweet_reset_time);
	}
	return "<a href='http://mqassist.ml/$username'>$content</a>";  // acceptable variables after extract
});


function curl($url){
	$c = curl_init($url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); // echo or transfer into a variable, 1 is true
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3); // give it a timeout of 3sec.
	curl_setopt($c, CURLOPT_TIMEOUT, 5); //standard timeout
	return json_decode(curl_exec($c));
}

function fetch_tweets($num_tweets, $username, $tweet_reset_time) {
		$tweets = curl("http://127.0.0.1:1337/products.json");
		//echo 'TWEETS: ';print_r($tweets);
		echo 'TWEETS: ';print_r($tweets->Object->results[0]->text);
		// tweets.Object.results[0].text (in javascript)
};

*/

/*
///06 - Tweets Project - Part 2
/// [twitter  username="myusername" show_tweets='true'] 

add_shortcode('twitter', function($atts, $content){ 
	//print_r($atts);die();
	$atts = shortcode_atts(
		array(
			'username' => 'raymacz',
			'content' => !empty($content) ? $content : 'Follow me now!!!',
			'show_tweets' => false,
			'tweet_reset_time' => 10,
			'num_tweets' => 8, // max of tweets to display
		), $atts
	);
	
	extract($atts);	//extract - gets values from an array and convert it to variables.
	if ($show_tweets) {
		$tweets= fetch_tweets($num_tweets, $username, $tweet_reset_time);
	}
	return "$tweets <p><a href='http://mqassist.ml/$username'>$content</a></p>";  
		// acceptable variables after extract
		// will display <ul> list & <p>
});


function curl($url){
	$c = curl_init($url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); // echo or transfer into a variable, 1 is true
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3); // give it a timeout of 3sec.
	curl_setopt($c, CURLOPT_TIMEOUT, 5); //standard timeout
	return json_decode(curl_exec($c));
}

function fetch_tweets($num_tweets, $username, $tweet_reset_time) {
		$tweets = curl("http://127.0.0.1:1337/products.json");
		//echo 'TWEETS: ';print_r($tweets->Object->results[0]->text);
		// tweets.Object.results[0].text (in javascript)
		$data = array();
		$tweets =$tweets->Object->results; // get only the results array
		//echo 'myTWEETSx: ';print_r($tweets);die();
		foreach ($tweets as $tweet) {
			if ($num_tweets-- === 0) break; //break out of the loop if the tweets has reach the max limit to display.
			//$data[] = $tweet->Object->results[0]->text;	
			$data[] = $tweet->text;	
		}
		//echo 'myTWEETSx: ';print_r($data);die();
		$recent_tweets = array( (int)date('i', time())); // if time() is 2nd paramater, its current time. 'i'- 2-digit minute // (int) cast into integer
		//echo 'x: ';print_r($recent_tweets);
		$recent_tweets[] = '<ul class="jw_recent_tweets"><li>'.implode('</li><li>', $data). '</li></ul>'; 
			/// implode - turns an array into individual string w/ separator
			/// craet a fragment
		//echo 'y: ';print_r($recent_tweets);die();
		cache_meta($recent_tweets); 
		return($recent_tweets[1]); // return the tweets <ul>
};

	
function cache_meta($recent_tweets) {
	// $recent_tweets[0] = current minute
	// $recent_tweets[1] = tweet html fragment
	global $id;
	add_post_meta($id, 'jw_recent_tweets', $recent_tweets); // Add meta data field to a post.
		// $id - post id#, jw_recent_tweets - any name identifier we can put
};	

*/

/// [twitter  username="myusername" show_tweets='true']  ///06 - Tweets Project - Part 3

add_shortcode('twitter', function($atts, $content){ 
	echo "shortcode enabled!";
//        print_r($atts);die();
	$atts = shortcode_atts(
		array(
			'username' => 'raymacz',
			'content' => !empty($content) ? $content : 'Follow me now!!!',
			'show_tweets' => false,
			'tweet_reset_time' => 2, // # of min
			'num_tweets' => 8, // max of tweets to display
		), $atts
	);
	extract($atts);	//extract - gets values from an array and convert it to variables.
	if ($show_tweets) {
		$tweets= fetch_tweets($num_tweets, $username, $tweet_reset_time);
	}
	return "$tweets <p><a href='http://mqassist.ml/$username'>$content</a></p>";  
		// acceptable variables after extract
		// will display <ul> list & <p>
});


function curl($url){
	$c = curl_init($url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); // echo or transfer into a variable, 1 is true
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3); // give it a timeout of 3sec.
	curl_setopt($c, CURLOPT_TIMEOUT, 5); //standard timeout
	return json_decode(curl_exec($c));
}

function fetch_tweets($num_tweets, $username, $tweet_reset_time) {
		global $id;
		//delete_post_meta($id, 'jw_recent_tweets');die();
		$recent_tweets = get_post_meta($id, 'jw_recent_tweets');
		//echo 'TWEETS: ';print_r($recent_tweets);
//                $time_now=date('Y-m-d H:i:s',time());
//                $time_before=date('Y-m-d H:i:s',time()-(1*60));
//                $time_diff= date('H:i:s', strtotime($time_now)-strtotime($time_before));
		$has_reset=reset_data($recent_tweets, $tweet_reset_time); // reset old tweets if there is any
//		if (empty($recent_tweets)) { // if no cache, fetch new tweets and cache
		if ($has_reset or empty($recent_tweets) ) { // if no cache, fetch new tweets and cache
			$tweets = curl("http://127.0.0.1:1337/products.json");
			//echo 'TWEETS: ';print_r($tweets->Object->results[0]->text);
			// tweets.Object.results[0].text (in javascript)
			$data = array();
			$tweets =$tweets->Object->results; // get only the results array
			//echo 'myTWEETSx: ';print_r($tweets);die();
                        if (isset($tweets)) :
                            foreach ($tweets as $tweet) {
                                    if ($num_tweets-- === 0) break; //break out of the loop if the tweets has reach the max limit to display.
                                    //$data[] = $tweet->Object->results[0]->text;	
                                    $data[] = $tweet->text;
                            }
                        else :
                            $data[] = "No Tweets fetched! Reloading in $tweet_reset_time minutes...";
                        endif;
			//echo 'myTWEETSx: ';print_r($data);die(); 
//			$new_tweets = array( (int)date('i', time())); // if time() is 2nd paramater, its current time. 'i'- 2-digit minute // (int) cast into integer
			$new_tweets = array( date('Y-m-d H:i:s',time()));
			$new_tweets[] = '<ul class="jw_recent_tweets"><li>'.implode('</li><li>', $data). '</li></ul>'; 
				/// implode - turns an array into individual string w/ separator & create a fragment
			cache_meta($new_tweets); // add time & tweet to post meta
		}
		return isset($new_tweets[1]) ? $new_tweets[1] : $recent_tweets[0][1]; // return the tweets <ul>
};
	
function cache_meta($n_tweets) {
	// $n_tweets[0] = current minute
	// $n_tweets[1] = tweet html fragment
	global $id;
	add_post_meta($id, 'jw_recent_tweets', $n_tweets, true); // Add meta data field to a post.
		// $id - post id#, jw_recent_tweets - any name identifier we can put, true - should be unique
};	


function reset_data($recent_tweets, $tweet_reset_time) {
	global $id;
	if (isset($recent_tweets[0][0])) {
//		if ($delay >= 60) $delay -= 60; // if time > oclock, then subtract 60 - minutes only, hour excluded
                $t_now = date('Y-m-d H:i:s',time());
                $t_before = $recent_tweets[0][0];
                $time_diff = strtotime($t_now) - strtotime($t_before);
		if ((int)$time_diff > ((int)$tweet_reset_time*60))	{ // if post last updated was later than reset time  (1min)
				delete_post_meta($id, 'jw_recent_tweets'); //stop increment of post_meta & delete the old meta.
                                return true;
		}
	}
        return false;
};	


?>