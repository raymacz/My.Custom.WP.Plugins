<?php
/**
* Plugin Name: Webmacz Custom Post Types
* Description: Creating posttypes for taxonomies
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:mqassist.com
* License: GPL2+
*
*/

/*

Copyright 2018 Raymacz

Webmacz Custom Post Types is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Webmacz Custom Post Types is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Webmacz Custom Post Types. If not, see the Free Software Fondation, Inc.,
51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

*/

// Register Custom Post Type
function rbtm_init_services_cpt() {

	$labels = array(
		'name'                  => _x( 'Services', 'Post Type General Name', 'webmacz' ),
		'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'webmacz' ),
		'menu_name'             => __( 'Services', 'webmacz' ),
		'name_admin_bar'        => __( 'Services', 'webmacz' ),
		'archives'              => __( 'Item Archives', 'webmacz' ),
		'attributes'            => __( 'Item Attributes', 'webmacz' ),
		'parent_item_colon'     => __( 'Parent Service', 'webmacz' ),
		'all_items'             => __( 'All Services', 'webmacz' ),
		'add_new_item'          => __( 'Add New Item Service', 'webmacz' ),
		'add_new'               => __( 'Add New Service', 'webmacz' ),
		'new_item'              => __( 'New Service Item', 'webmacz' ),
		'edit_item'             => __( 'Edit Service Item', 'webmacz' ),
		'update_item'           => __( 'Update Service Item', 'webmacz' ),
		'view_item'             => __( 'View Service Item', 'webmacz' ),
		'view_items'            => __( 'View Service Items', 'webmacz' ),
		'search_items'          => __( 'Search service item', 'webmacz' ),
		'not_found'             => __( 'No services found', 'webmacz' ),
		'not_found_in_trash'    => __( 'No services found in trash', 'webmacz' ),
		'featured_image'        => __( 'Featured Image', 'webmacz' ),
		'set_featured_image'    => __( 'Set featured image', 'webmacz' ),
		'remove_featured_image' => __( 'Remove featured image', 'webmacz' ),
		'use_featured_image'    => __( 'Use as featured image', 'webmacz' ),
		'insert_into_item'      => __( 'Insert into service item', 'webmacz' ),
		'uploaded_to_this_item' => __( 'Uploaded to this service item', 'webmacz' ),
		'items_list'            => __( 'Service items list', 'webmacz' ),
		'items_list_navigation' => __( 'Service items list navigation', 'webmacz' ),
		'filter_items_list'     => __( 'Filter service Items list', 'webmacz' ),
	);
	$rewrite = array(
		'slug'                  => 'service',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Service', 'webmacz' ),
		'description'           => __( 'Services that we offer.', 'webmacz' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-site',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'service', $args );

}
add_action( 'init', 'rbtm_init_services_cpt', 0 );


// Register Custom Post Type
function rbtm_init_portfolio_cpt() {

	$labels = array(
		'name'                  => _x( 'Properties', 'Post Type General Name', 'webmacz' ),
		'singular_name'         => _x( 'Property', 'Post Type Singular Name', 'webmacz' ),
		'menu_name'             => __( 'Property', 'webmacz' ),
		'name_admin_bar'        => __( 'Properties', 'webmacz' ),
		'archives'              => __( 'Item Archives', 'webmacz' ),
		'attributes'            => __( 'Item Attributes', 'webmacz' ),
		'parent_item_colon'     => __( 'Parent Item Property', 'webmacz' ),
		'all_items'             => __( 'All Item Properties', 'webmacz' ),
		'add_new_item'          => __( 'Add New Item Property', 'webmacz' ),
		'add_new'               => __( 'Add New Property', 'webmacz' ),
		'new_item'              => __( 'New Property Item', 'webmacz' ),
		'edit_item'             => __( 'Edit Property Item', 'webmacz' ),
		'update_item'           => __( 'Update Property Item', 'webmacz' ),
		'view_item'             => __( 'View Property Item', 'webmacz' ),
		'view_items'            => __( 'View Property Items', 'webmacz' ),
		'search_items'          => __( 'Search Property item', 'webmacz' ),
		'not_found'             => __( 'No Properties found', 'webmacz' ),
		'not_found_in_trash'    => __( 'No Properties found in trash', 'webmacz' ),
		'featured_image'        => __( 'Featured Image', 'webmacz' ),
		'set_featured_image'    => __( 'Set Featured Image', 'webmacz' ),
		'remove_featured_image' => __( 'Remove Featured Image', 'webmacz' ),
		'use_featured_image'    => __( 'Use as Featured Image', 'webmacz' ),
		'insert_into_item'      => __( 'Insert into Property Item', 'webmacz' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Property Item', 'webmacz' ),
		'items_list'            => __( 'Property items list', 'webmacz' ),
		'items_list_navigation' => __( 'Property items list navigation', 'webmacz' ),
		'filter_items_list'     => __( 'Filter Property Items list', 'webmacz' ),
	);
	$rewrite = array(
		'slug'                  => 'portfolio',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Properties', 'webmacz' ),
		'description'           => __( 'A list of our Properties.', 'webmacz' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'author' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'rbtm_init_portfolio_cpt', 0 );

// Register Custom Post Type
function rbtm_init_team_cpt() {

	$labels = array(
		'name'                  => _x( 'Teams', 'Post Type General Name', 'webmacz' ),
		'singular_name'         => _x( 'Team', 'Post Type Singular Name', 'webmacz' ),
		'menu_name'             => __( 'Team', 'webmacz' ),
		'name_admin_bar'        => __( 'Teams', 'webmacz' ),
		'archives'              => __( 'Item Archives', 'webmacz' ),
		'attributes'            => __( 'Item Attributes', 'webmacz' ),
		'parent_item_colon'     => __( 'Parent Item Team', 'webmacz' ),
		'all_items'             => __( 'All Item Teams', 'webmacz' ),
		'add_new_item'          => __( 'Add New Item Team', 'webmacz' ),
		'add_new'               => __( 'Add New Team', 'webmacz' ),
		'new_item'              => __( 'New Team Item', 'webmacz' ),
		'edit_item'             => __( 'Edit Team Item', 'webmacz' ),
		'update_item'           => __( 'Update Team Item', 'webmacz' ),
		'view_item'             => __( 'View Team Item', 'webmacz' ),
		'view_items'            => __( 'View Team Items', 'webmacz' ),
		'search_items'          => __( 'Search team item', 'webmacz' ),
		'not_found'             => __( 'No team member found', 'webmacz' ),
		'not_found_in_trash'    => __( 'No team member found in trash', 'webmacz' ),
		'featured_image'        => __( 'Featured Image', 'webmacz' ),
		'set_featured_image'    => __( 'Set Featured Image', 'webmacz' ),
		'remove_featured_image' => __( 'Remove Featured Image', 'webmacz' ),
		'use_featured_image'    => __( 'Use as Featured Image', 'webmacz' ),
		'insert_into_item'      => __( 'Insert into Team Item', 'webmacz' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Team Item', 'webmacz' ),
		'items_list'            => __( 'Team items list', 'webmacz' ),
		'items_list_navigation' => __( 'Team items list navigation', 'webmacz' ),
		'filter_items_list'     => __( 'Filter Team Items list', 'webmacz' ),
	);
	$rewrite = array(
		'slug'                  => 'team',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => __( 'Team', 'webmacz' ),
		'description'           => __( 'A list of our team members.', 'webmacz' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'team', $args );

}
add_action( 'init', 'rbtm_init_team_cpt', 0 );


// Register Custom Post Type
function init_about_cpt() {

	$labels = array(
		'name'                  => _x( 'About Events', 'Post Type General Name', 'webmacz' ),
		'singular_name'         => _x( 'About Event', 'Post Type Singular Name', 'webmacz' ),
		'menu_name'             => __( 'About Events', 'webmacz' ),
		'name_admin_bar'        => __( 'About Events', 'webmacz' ),
		'archives'              => __( 'Item Archives', 'webmacz' ),
		'attributes'            => __( 'Item Attributes', 'webmacz' ),
		'parent_item_colon'     => __( 'Parent About Event', 'webmacz' ),
		'all_items'             => __( 'All About Events', 'webmacz' ),
		'add_new_item'          => __( 'Add New Item About Event', 'webmacz' ),
		'add_new'               => __( 'Add New About Event', 'webmacz' ),
		'new_item'              => __( 'New About Event Item', 'webmacz' ),
		'edit_item'             => __( 'Edit About Event Item', 'webmacz' ),
		'update_item'           => __( 'Update About Event Item', 'webmacz' ),
		'view_item'             => __( 'View About Event Item', 'webmacz' ),
		'view_items'            => __( 'View About Event Items', 'webmacz' ),
		'search_items'          => __( 'Search about event item', 'webmacz' ),
		'not_found'             => __( 'No About Event found', 'webmacz' ),
		'not_found_in_trash'    => __( 'No About Event found in trash', 'webmacz' ),
		'featured_image'        => __( 'Featured Image', 'webmacz' ),
		'set_featured_image'    => __( 'Set featured image', 'webmacz' ),
		'remove_featured_image' => __( 'Remove featured image', 'webmacz' ),
		'use_featured_image'    => __( 'Use as featured image', 'webmacz' ),
		'insert_into_item'      => __( 'Insert into about event item', 'webmacz' ),
		'uploaded_to_this_item' => __( 'Uploaded to this about event item', 'webmacz' ),
		'items_list'            => __( 'About Event items list', 'webmacz' ),
		'items_list_navigation' => __( 'About Event items list navigation', 'webmacz' ),
		'filter_items_list'     => __( 'Filter About Event Items list', 'webmacz' ),
	);
	$args = array(
		'label'                 => __( 'About Event', 'webmacz' ),
		'description'           => __( 'Company History & what is it all about.', 'webmacz' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => false,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'about', $args );

}
add_action( 'init', 'init_about_cpt', 0 );

function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    rbtm_init_services_cpt();
    rbtm_init_portfolio_cpt(); // my_cpt_init(); // rbtm
    rbtm_init_team_cpt();
    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );


?>
