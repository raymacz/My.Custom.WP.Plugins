<?php

// WP CRON

// add control intervals
function loginadmin_wpcron_intervals($schedules) {
    
//    $option = get_option('wpcron_log'); 
//    if (!empty($option) && is_array($option)) delete_option('wpcron_log');
    
    
    // one minute
    $one_minute  = array (
       'interval'   => 60,
        'display'   => 'One Minute Test'
    );
    
    $schedules['one_minute'] = $one_minute;
    
    // five minutes
    $five_minutes = array(
      'interval'   => 300,
      'display'    => 'Five Minutes Test'
    );
    
     $schedules['five_minutes'] = $five_minutes;
    // return data
    return $schedules;
}
add_filter('cron_schedules','loginadmin_wpcron_intervals');





// cron event
function loginadmin_wpcron_example_event() {
    if (!defined('DOING_CRON')) return; // this function only runs when cron is executed (doing cron) / prevents outside of running cron
    
    $option = get_option('wpcron_log'); 
    
    if (!empty($option) && is_array($option)) {
        $option[]=date('h:i:s A'); // added a new date log
    } else {
        $option = array(date('h:i:s A')); // initialize a new date log
    }
       
    update_option('wpcron_log', $option);
}
add_action('example_event', 'loginadmin_wpcron_example_event'); // this runs when the newly registered hook is executed during an event





// GET response
function loginadmin_show_my_cron() {
  
//   echo '<pre>rbtm dump: ';
//   var_dump($response);
//   echo '</pre>';
//   die();
    $option = get_option('wpcron_log'); 
    
//   $code = wp_remote_retrieve_response_code( $response );
//   $header_date = wp_remote_retrieve_header( $response, 'date' );
   

   //output data
    $output = '<h2>WP Cron: RBTM</h2>';
    $output .= __FILE__;
    $output .= '<pre>';
    var_dump($option);

   $output .= '</pre>';

   return $output;

}

    
//add cron event
function loginadmin_wpcronz_act() {
    echo 'example event entry'; 
    if (!wp_next_scheduled('example_event')) {
        wp_schedule_event(time(), 'one_minute', 'example_event');
    }
    flush_rewrite_rules();
}
register_activation_hook( PLUGIN_BASE_PATH, 'loginadmin_wpcronz_act' );


// remove cron event
function loginadmin_wpcron_deactivation() {
    wp_clear_scheduled_hook('example_event');
    delete_option('wpcron_log');
}
register_deactivation_hook(PLUGIN_BASE_PATH, 'loginadmin_wpcron_deactivation');