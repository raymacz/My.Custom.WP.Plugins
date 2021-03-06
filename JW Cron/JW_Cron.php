<?php
error_reporting(E_ALL); //during developement, add this to help in making WP plugins
/**
* Plugin Name: JW Cron
* Description: A schedule based job using WP Cron. Schedule an event and run a particular script shown in the admin page. 
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
	 	wp_schedule_event(time(), 'fortyfive-min', 'jw_cron_hook'); // set cron to run in a scheduled event
//		wp_schedule_event(time(), 'hourly', 'jw_cron_hook'); // fires multiple times according to schedule
//		wp_schedule_single_event(time() + 3600, 'jw_cron_hook'); //time() - now  & 3600 secs // fires only once
		
		// everytime you load a page (e.g. administration page), you will schedule a cron job
		// note: even if the time has elapsed (say 2min.), WP cron won't send email unless a page load occurred.
	}
});

add_action('admin_menu', function() { //Fires before the administration menu loads in the admin.
	add_options_page('Cron Settings Page', 'Cron Settings Menu', 'manage_options', 'jw_cron', function() {
		$cron= _get_cron_array(); // this shows the cron event schedules (e.g. updates for plugins, themes, version), it also shows custom hooks we made
		$schedules= wp_get_schedules(); // displays all schedule
		?>
		<div class="wrap">
			<h1>Cron Events Scheduled </h1>	
			<?php
                        echo "<h2>Shows WP supported preset schedules (including custom schedules):</h2>";
			foreach($schedules as $name) { 
				echo '<h3> '. $name["display"]. ': '. $name["interval"].  ' sec(s).</h3>';
			}
			?> 
			<!-- <pre><?php // print_r($cron); ?></pre> -->
			<?php
                        echo "<br><h2>Shows cron scheduled jobs:</h2>";
			foreach($cron as $time => $hook) { 
				echo "<h3>".date('m-d-Y H:i:s', $time)."</h3>";
				foreach($hook as $k => $v) {
					echo ' JOB: '.$k;
//					 print_r($v);
					foreach($v as $k1 => $v1) {
                                                echo  ' SCHEDULE: '.$v1['schedule'].' &nbsp;/&nbsp; ';
//						 print_r($v1);
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
//	wp_mail('raymacz76@gmail.com', 'Scheduled with WP_Cron!', "This email was sent at $str."); // send email
        echo "emailz sent at $str";
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
	return $schedules;
});

?>