<?php
/*
 * Loginadmin - Manage users and roles
 */

//add top-level administrative menu
function loginadmin_update_user_add_toplevel_menu() {
//    add_menu_page(
//        esc_html__('Users and Roles: Update User', 'loginadmin'),
//        esc_html__('Create User', 'loginadmin'),
//        'manage_options',
//        'loginadmin',
//        'loginadmin_update_user_display_settings_page',
//        'dashicons-admin-generic',
//        null
//    );
    add_submenu_page(
        'options-general.php',
//        esc_html__('Users and Roles: Update User', 'loginadmin'),
//        esc_html__('Create User', 'loginadmin'),
        'Users and Roles: Update User',
        'Update User',
        'manage_options',
        'update-users',
        'loginadmin_update_user_display_settings_page'
    );
}
add_action('admin_menu','loginadmin_update_user_add_toplevel_menu');

//display the plugin settings page
function loginadmin_update_user_display_settings_page() {

    //check if user is allowed access
    if (!current_user_can('manage_options')) return;

?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <form method="post">
      <h3><?php esc_html_e('Update User', 'loginadmin'); ?></h3>
    <p>
      <label for="email"><?php esc_html_e('Enter the user&rsquo;s email (required)', 'loginadmin');?></label><br />
      <input type="text" class="regular-text" size="40" name="email" id="email">
    </p>
    <p>
      <label for="display-name"><?php esc_html_e('Enter a new Display Name:', 'loginadmin');?></label><br />
      <input type="text" class="regular-text" size="40" name="display-name" id="display-name">
    </p>
    <p>
      <label for="user-url"><?php esc_html_e('Enter a new Website URL:', 'loginadmin');?></label><br />
      <input type="text" class="regular-text" size="40" name="user-url" id="user-url">
    </p>
    <p><?php esc_html_e('The user will be notified via email', 'loginadmin');?>
    </p>

    <input type="hidden" name="loginadmin-update-nonce" value="<?php echo wp_create_nonce('loginadmin-update-nonce'); ?>">
    <input type="submit" class="button button-primary" value="<?php echo esc_html_e('Update User','loginadmin'); ?>">
  </form>
</div>
<?php
}

//add new user
function loginadmin_update_user_update_user() {

//check if nonce is valid
if (isset($_POST['loginadmin-update-nonce']) && wp_verify_nonce($_POST['loginadmin-update-nonce'], 'loginadmin-update-nonce')) {

    //check if user is allowed
    if (!current_user_can('manage_options')) wp_die();

    //get submitted email
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
    } else {
        $email = '';
    }

    //get new display name
    if(isset($_POST['display-name']) && !empty($_POST['display-name'])) {
        $display_name = sanitize_user($_POST['display-name']);
    } else {
        $display_name = '';
    }

    //get new website url
    if(isset($_POST['user-url']) && !empty($_POST['user-url'])) {
        $user_url = esc_url($_POST['user-url']);
    } else {
        $user_url = '';
    }

    //set user_id
    $user_id = email_exists($email);

    //user id exists
    if (is_numeric($user_id)) {
        //define the parameters
        $userdata = array ('ID'=>$user_id, 'display_name'=>$display_name, 'user_url'=>$user_url);

        //update the user
        $user_id = wp_update_user($userdata);

       //get the error message
        if(is_wp_error($user_id)) {
            $user_id = $user_id->get_error_message();
        }

    } else {
         //user not found
        $user_id = __('User not found!','loginadmin');
    }

     $location = admin_url('admin.php?page=update-users&result='.urlencode($user_id));
     wp_redirect($location);
     exit; //very important to exit after wp_redirect()

 } //if nonce is valid
}
add_action('admin_init', 'loginadmin_update_user_update_user');

// no more unlike  loginadmin_create_user_admin_notices ?
