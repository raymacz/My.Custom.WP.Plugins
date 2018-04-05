<?php

error_reporting(E_ALL); //during developement, add this to help in making WP plugins
/**
* Plugin Name: JW Cron
* Description: WP Cron Jobs
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* Text Domain: jw
* License: GPL2+
*
*/


add_action('init', function(){
	$time= wp_next_scheduled('jw_cron_hook'); // Retrieve the next timestamp for an event.
//	wp_unschedule_event($time, 'jw_cron_hook'); // unschedule the event timestamp 
	//note:  Important! Be careful when using wp_unschedule_event() as it will remove your existing wp_mail() event & will refresh / execute (e.g. send email) everytime the page loads.
	
    if (!wp_next_scheduled('jw_cron_hook')) {
	 //	wp_schedule_event(time(), 'fortyfive-min', 'jw_cron_hook'); // set cron to run in a scheduled event
		//wp_schedule_event(time(), 'hourly', 'jw_cron_hook'); // fires multiple times according to schedule
		
		// everytime you load a page (e.g. administration page), you will schedule a cron job
		// note: even if the time has elapsed (say 2min.), WP cron won't send email unless a page load occurred.
		
		// wp_schedule_single_event(time() + 3600, 'jw_cron_hook'); //time() - now  & 3600 secs // fires only once
	}
});

add_action('admin_menu', function() { //Fires before the administration menu loads in the admin.
	add_options_page('Cron Settings Page', 'Cron Settings Menu', 'manage_options', 'jw_cron', function() {
		$cron= _get_cron_array(); // this shows the cron event schedules (e.g. updates for plugins, themes, version), it also shows custom hooks we made
		$schedules= wp_get_schedules(); // displays all schedule
		?>
		<div class="wrap">
			<h2>Cron Events Scheduled </h2>	
			<pre><?php print_r($schedules); ?></pre>
			<?php
			foreach($schedules as $name) { 
				echo '<h3> '. $name["display"]. ': '. $name["interval"].  '</h3>';
			}
			?> 
			<!-- <pre><?php // print_r($cron); ?></pre> -->
			<?php
			foreach($cron as $time => $hook) { 
				echo "<h3>$time</h3>";
			//	 print_r($hook);
				foreach($hook as $k => $v) {
					//echo $k.'=> '.$v;	
				//	echo $k;
				//	 print_r($v);
					foreach($v as $k1 => $v1) {
						//echo $k.'=> '.$v;	
					//	echo $k1;
						 print_r($v1);
					}
				}
			} 	
			?>
		</div>	
		<?php
	});
});	

add_action('jw_cron_hook', function(){
    $str=time();
	wp_mail('raymacz76@gmail.com', 'Scheduled with WP_Cron!', "This email was sent at $str."); // send email
});

add_filter('cron_schedules',  function ($schedules) { // change the preset by customizing your own schedule 
	//print_r($schedules);die(); 
	$schedules['fortyfive-min']	= array(
		'interval' => 2700,
		'display' => 'Every 45 minutes'
	);
	$schedules['two-min']	= array(
		'interval' => 120,
		'display' => 'Every 2 minutes'
	);
//	print_r($schedules);
	return $schedules;
});

?>