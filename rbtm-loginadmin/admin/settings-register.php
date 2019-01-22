<?php

/* 
 * loginadmin - Register Settings
 */


// exit if file is called directly
if ( ! defined ('ABSPATH')) {
   exit;
}

// register plugin settings
function loginadmin_register_settings() {
    
    /*
     * register_settings (
     *      string $options_group, // it must match under settings_fields() in the settings-page.php
     *      string $options_name,
     *      callable $sanitize_callback
     * );
     */
    
    register_setting('loginadmin_options','loginadmin_options', 'loginadmin_callback_validate_options');
    
    /*
     * add_settings_section(
     *      string $id,
     *      string $title,
     *      callable $callback,
     *      string $page //$menu_slug
     * );
     */
    
    add_settings_section('loginadmin_section_login', 'Customize Login Page', 'loginadmin_callback_section_login', 'loginadmin');
    add_settings_section('loginadmin_section_admin', 'Customize Admin Area', 'loginadmin_callback_section_admin', 'loginadmin');
    
    /*
     * add_settings_field(
     *  string $id, // must match the $id in add_settings_section()
     *  string  $title,
     *  callable $callback,
     *  string $page,
     *  string $section = 'default',
     *  array $args = []
     * );
     */
    
    //loginadmin_section_login
    add_settings_field(
        'custom_url',
        'Custom URL',
        'loginadmin_callback_field_text',
        'loginadmin',
        'loginadmin_section_login',
        ['id'=>'custom_url', 'label'=>'Custom URL for the login logo link' ]
    );
    add_settings_field(
        'custom_title',
        'Custom Title',
        'loginadmin_callback_field_text',
        'loginadmin',
        'loginadmin_section_login',
        ['id'=>'custom_title', 'label'=>'Custom title attribute for the logo link' ]
    );
    add_settings_field(
        'custom_style',
        'Custom Style',
        'loginadmin_callback_field_radio',
        'loginadmin',
        'loginadmin_section_login',
        ['id'=>'custom_style', 'label'=>'Custom CSS for the login screen' ]
    );
    add_settings_field(
        'custom_message',
        'Custom Message',
        'loginadmin_callback_field_textarea',
        'loginadmin',
        'loginadmin_section_login',
        ['id'=>'custom_message', 'label'=>'Custom text and/or markup' ]
    );
    
    //loginadmin_section_admin
    add_settings_field(
        'custom_footer',
        'Custom Footer',
        'loginadmin_callback_field_text',
        'loginadmin',
        'loginadmin_section_admin',
        ['id'=>'custom_footer', 'label'=>'Custom footer text' ]
    );
    add_settings_field(
        'custom_toolbar',
        'Custom Toolbar',
        'loginadmin_callback_field_checkbox',
        'loginadmin',
        'loginadmin_section_admin',
        ['id'=>'custom_toolbar', 'label'=>'Remove new post and comment links from the Toolbar' ]
    );
    add_settings_field(
        'custom_scheme',
        'Custom Scheme',
        'loginadmin_callback_field_select',
        'loginadmin',
        'loginadmin_section_admin',
        ['id'=>'custom_scheme', 'label'=>'Default color scheme for the new users' ]
    );
}

add_action('admin_init', 'loginadmin_register_settings');
