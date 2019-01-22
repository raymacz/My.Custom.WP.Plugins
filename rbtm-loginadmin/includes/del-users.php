<?php
/*
 * Loginadmin - Manage users and roles - delete user
 */

//add top-level administrative menu
function loginadmin_delete_user_add_toplevel_menu() {
//    add_menu_page(
//        esc_html__('Users and Roles: Delete User', 'loginadmin'),
//        esc_html__('Delete User', 'loginadmin'),
//        'manage_options',
//        'loginadmin',
//        'loginadmin_delete_user_display_settings_page',
//        'dashicons-admin-generic',
//        null
//    );
   add_submenu_page(
        'options-general.php',
        esc_html__('Users and Roles: Delete User', 'loginadmin'),
        esc_html__('Delete User', 'loginadmin'),
        'manage_options',
        'del-users',
        'loginadmin_delete_user_display_settings_page'
    );    
}
 add_action('admin_menu','loginadmin_delete_user_add_toplevel_menu');

//display the plugin settings page
function loginadmin_delete_user_display_settings_page() {

    //check if user is allowed access
    if (!current_user_can('manage_options')) return;

?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <form method="post">
      <h3><?php esc_html_e('Delete user', 'loginadmin'); ?></h3>
    <p>
      <label for="email"><?php esc_html_e('Enter the user&rsquo;s email (required)', 'loginadmin');?></label><br />
      <input type="text" class="regular-text" size="40" name="email" id="email">
    </p>
    <p><?php esc_html_e('The user will be notified via email', 'loginadmin');?>
    </p>

    <input type="hidden" name="loginadmin-del-nonce" value="<?php echo wp_create_nonce('loginadmin-del-nonce'); ?>">
    <input type="submit" class="button button-primary" value="<?php echo esc_html_e('Delete User','loginadmin'); ?>">
  </form>
</div>
<?php
}

//add new user
function loginadmin_delete_user_delete_user() {

//check if nonce is valid
if (isset($_POST['loginadmin-del-nonce']) && wp_verify_nonce($_POST['loginadmin-del-nonce'], 'loginadmin-del-nonce')) {

    //check if user is allowed
    if (!current_user_can('manage_options')) wp_die();

    //get submitted email
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
    } else {
        $email = '';
    }

    //if user_id exists
    $user_id = email_exists($email);

    //check non-empty values
    if (is_numeric($user_id)) {
        $result = wp_delete_user($user_id);
        
        if ($result) {
            $result = __('The user has been deleted.', 'loginadmin');
        } else {
            $result = __('Error: user not deleted.', 'loginadmin');
        }
    } else {
         $result = __('Sorry, email does not exists!', 'loginadmin');   
    } 

     $location = admin_url('admin.php?page=loginadmin&result='.urlencode($user_id));
     wp_redirect($location);
     exit; //very important to exit after wp_redirect()
     
 } //if nonce is valid
}
 add_action('admin_init', 'loginadmin_delete_user_delete_user');
