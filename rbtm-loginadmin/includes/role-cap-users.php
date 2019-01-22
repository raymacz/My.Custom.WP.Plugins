<?php
/*
 * Loginadmin - Manage users and roles
 */

//add top-level administrative menu
function loginadmin_roles_user_add_toplevel_menu() {
   add_submenu_page(
        'options-general.php',
        esc_html__('Users and Roles:  Add & Remove Roles', 'loginadmin'),
        esc_html__('Add & Remove Roles', 'loginadmin'),
        'manage_options',
        'role-users',
        'loginadmin_roles_user_display_settings_page'
    );
}
 add_action('admin_menu','loginadmin_roles_user_add_toplevel_menu');

//display the plugin settings page
function loginadmin_roles_user_display_settings_page() {

    //check if user is allowed access
    if (!current_user_can('manage_options')) return;

?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <br />
     <h2><?php esc_html_e('Existing Roles: ', 'loginadmin'); ?></h2>
    <?php echo get_myroles();  ?>
     <br />
     <h5><?php esc_html_e('NOTE: Check code to remove or add roles as an example. ', 'loginadmin'); ?></h5>
     <div>
        <!--call functions with wpdb examples from lesson #31 WP Plugin Dev-->
       <?php loginadmin_db_get_user_count(); ?>
       <?php loginadmin_db_sum_custom_fields(); ?>
       <?php loginadmin_db_get_primary_admin(); ?>
       <?php loginadmin_db_get_all_users_ids(); ?>
       <?php loginadmin_db_get_draft_posts(); ?>
       <?php loginadmin_db_add_custom_field(); ?>
        <!--HTTP API response from lesson #34-->
        <?php echo loginadmin_http_get_response(); ?>
        <?php echo loginadmin_http_post_response(); ?>
        <!--WP Cron #35-->
        <?php echo loginadmin_show_my_cron(); ?>
        <?php echo loginadmin_ajax_admin_display_form(); ?>

     </div>
</div>
<?php
}

function get_myroles() {
    $all_roles = get_editable_roles();
    $rolez ='';
//    echo '<pre>rbtm dump: ';
//    var_dump($all_roles);
//    die();
//    echo '</pre>';
    foreach ($all_roles as $role => $val ) {
        $rolez .=  '<p>'. $val['name'] . '</p>';
    }

     return  $rolez;
}

//get user role
function loginadmin_users_role_get_role($role_name) {
    return get_role($role);
}



//add new user
function loginadmin_users_role_add_role() {

    add_role('reviewer', __('Reviewer'), array(
        'read'          => true,
        'edit_posts'    => true,
        'upload_files'  => true,
    ));

}
//add_action('init', 'loginadmin_users_role_add_role');


//remove user role
function loginadmin_users_role_remove_role() {
    remove_role('reviewer');
}
//add_action('init', 'loginadmin_users_role_remove_role');
