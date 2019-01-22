<?php // loginadmin - Settings Page

// exit if file is called directly
if ( ! defined ('ABSPATH')) {
   exit;
}



// display the plugin settings page
function loginadmin_display_settings_page() {

    //check if user is allowed access
    if (!current_user_can('manage_options')) return;
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title());?></h1>
        <!-- #1 admin notices settings error - only applies if not located under admin settings sublevel page -->
          <?php // settings_errors(); ?>
        <!-- #1 admin notices settings error -->
        <form action="options.php" method="post" class="test">
            <?php
            //output security fields
            settings_fields('loginadmin_options');
            //output settings sections
            do_settings_sections('loginadmin'); //$menu_slug
            //submit button
            submit_button();
            ?>
        </form>
    </div>


    <?php


}

// #2 admin notices settings error - only applies if not located under admin settings sublevel page
 // function loginadmin_admin_notices() {
 //    settings_errors();
 // }
 // add_action('admin_notices', 'loginadmin_admin_notices');
// #2 admin notices settings error



// #3 admin notices settings error - only applies if not located under admin settings page
// display admin admin notices
function loginadmin_admin_notices() {
  //get the current screen
  $screen = get_current_screen();

  // return if not loginadmin settings page
  if ($screen->id != 'toplevel_page_loginadmin') return;

  //check if settings is updated
  if (isset($_GET['settings-updated'])) {
     //if settings updated successfully
     if ($_GET['settings-updated'] === 'true') :
       ?>
       <div class="notice notice-success is-dismissable">
         <p><strong><?php _e('Congratz! you are awesome...','loginadmin');?></strong></p>
       </div>
     <?php else: //if error?>
       <div class="notice notice-success is-dismissable">
         <p><strong><?php _e('Houston! We have a problem...','loginadmin');?></strong></p>
       </div>
     <?php
     endif;
  }
}
add_action('admin_notices', 'loginadmin_admin_notices');
// #3 admin notices settings error
