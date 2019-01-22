<?php

/* 
 * uninstall.php
 * 
 * fires when plugin is uninstalled via the Plugin screen
 */

// exit if uninstall contant is not defined
if ( ! defined('WP_UNINSTALL_PLUGIN')) {
   exit;
}

//delete the plugin options
    delete_option('loginadmin_options');
    
    
/*
 * techniques:
 * 
 * delete options:                      delete_option()
 * delete options (multisite):          delete_site_option()
 * delete transient:                    delete_transient()
 * delete metadata:                     delete_metadata()
 * 
 * 
 * Delete database table:
 * 
 * global $wpdb;
 * $table_name = $wpdb->prefix.'myplugin_table';
 * $wpdb->query("DROP TABLE IF EXISTS {$table_name}");
 * 
 * Delete cron event:
 * 
 * $timestamp = wp_next_scheduled('sfs_cron_cache');
 * wp_unschedule_event($timestamp, 'sfs_cron_cache');
 * 
 * 
 * 
 */    
    
  