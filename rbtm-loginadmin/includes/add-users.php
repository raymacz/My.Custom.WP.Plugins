<?php
/*
 * Loginadmin - Manage users and roles
 */

//add top-level administrative menu
function loginadmin_create_user_add_toplevel_menu() {
//    add_menu_page(
//        esc_html__('Users and Roles: Create User', 'loginadmin'),
//        esc_html__('Create User', 'loginadmin'),
//        'manage_options',
//        'loginadmin',
//        'loginadmin_create_user_display_settings_page',
//        'dashicons-admin-generic',
//        null
//    );
   add_submenu_page(
        'options-general.php',
        esc_html__('Users and Roles: Create User', 'loginadmin'),
        esc_html__('Create User', 'loginadmin'),
        'manage_options',
        'add-users',
        'loginadmin_create_user_display_settings_page'
    );    
}
add_action('admin_menu','loginadmin_create_user_add_toplevel_menu');

//display the plugin settings page
function loginadmin_create_user_display_settings_page() {

    //check if user is allowed access
    if (!current_user_can('manage_options')) return;

?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <form method="post">
      <h3><?php esc_html_e('Add new user', 'loginadmin'); ?></h3>
    <p>
      <label for="username"><?php esc_html_e('Username', 'loginadmin');?></label><br />
      <input type="text" class="regular-text" size="40" name="username" id="username">
    </p>
    <p>
      <label for="email"><?php esc_html_e('Email', 'loginadmin');?></label><br />  
      <input type="text" class="regular-text" size="40" name="email" id="email">
    </p>
    <p>
      <label for="password"><?php esc_html_e('Password', 'loginadmin');?></label><br />  
      <input type="text" class="regular-text" size="40" name="password" id="password">
    </p>
    <p><?php esc_html_e('The user will be notified via email', 'loginadmin');?>        
    </p>
    
    <input type="hidden" name="loginadmin-nonce" value="<?php echo wp_create_nonce('loginadmin-nonce'); ?>">
    <input type="submit" class="button button-primary" value="<?php echo esc_html_e('Add User','loginadmin'); ?>">
  </form>
</div>
<?php
}

//add new user
function loginadmin_create_user_add_user() {
    
//check if nonce is valid
if (isset($_POST['loginadmin-nonce']) && wp_verify_nonce($_POST['loginadmin-nonce'], 'loginadmin-nonce')) {
    
    //check if user is allowed    
    if (!current_user_can('manage_options')) wp_die();

    //get submitted username
    if(isset($_POST['username']) && !empty($_POST['username'])) {
        $username = sanitize_user($_POST['username']);
    } else {
        $username = '';
    }
    
    //get submitted email
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
    } else {
        $email = '';
    }   
    
    //get submitted password
    if(isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = wp_generate_password();
    }   
    
    //set user_id 
    $user_id = '';
    
    //check if user exists
    $username_exists = username_exists($username);
    $email_exists = email_exists($email);
    
    if ($username_exists || $email_exists) {
        $user_id = esc_html__('The user already exists.', 'loginadmin');
    }
    
    //check non-empty values
    if (empty($username) || empty($email)) {
        $user_id = esc_html__('Required: username and email.', 'loginadmin');
    }
    
    //check the user
    if (empty($user_id)) {
//        die(); 
        $user_id = wp_create_user($username, $password, $email);
        
        if(is_wp_error($user_id)) {
            $user_id = $user_id->get_error_message();
        } else {
            //email password to newly registered user
            $subject = __('Welcome to our website!', 'loginadmin');
            $message = __('You can now login using your username and this password:!', 'loginadmin').$password;
            wp_mail($email, $subject, $message);
        }
    }
    
     $location = admin_url('admin.php?page=loginadmin&result='.urlencode($user_id));
     wp_redirect($location);
     exit; //very important to exit after wp_redirect()
     
 } //if nonce is valid      
}
add_action('admin_init', 'loginadmin_create_user_add_user');

//create the admin notices
function loginadmin_create_user_admin_notices() {
    $screen  = get_current_screen();
    if ('toplevel_page_loginadmin' === $screen->id)  {
        if (isset($_GET['result'])) {
            if (is_numeric($_GET['result'])) { ?>
                <div class="notice notice-success is-dismissable">
                    <p><strong>
                     <?php esc_html_e('User added successfully.','loginadmin') ?>   
                    </strong></p>    
                </div> 
        <?php } else { ?>
                <!--more to do-->
        <?php }
        }
    } 
}