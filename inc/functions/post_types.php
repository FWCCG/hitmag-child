<?php

function fyldecoastccgs_post_types() {
	register_post_type('staff', array(
	'public' => true,
	'show_in_rest' => true,
	'supports' => array( 'thumbnail', 'title' ),	
	'labels' => array(
		'name' => 'Staff members',
		'add_new_item' => 'Add new staff member', 
		'edit_item' => 'Edit staff member',
		'all_items' => 'All staff members',
		'singular_name' => 'Staff member',
	),	
	'menu_icon' => 	'dashicons-id-alt',	
	'exclude_from_search' => false,
	'capability_type' => 'post',	
	));
	
	register_post_type('practice', array(
	'label' => __( 'Practice', 'textdomain' ),
	'description' => __( 'GP Member practices', 'textdomain' ),
	'labels' => array(
		'name' => __( 'Practices', 'Post Type General Name', 'textdomain' ),
		'singular_name' => __( 'Practice', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => __( 'Practices', 'textdomain' ),
		'name_admin_bar' => __( 'Practice', 'textdomain' ),
		'archives' => __( 'Practice Archives', 'textdomain' ),
		'attributes' => __( 'Practice Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Practice:', 'textdomain' ),
		'all_items' => __( 'All Practices', 'textdomain' ),
		'add_new_item' => __( 'Add New Practice', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Practice', 'textdomain' ),
		'edit_item' => __( 'Edit Practice', 'textdomain' ),
		'update_item' => __( 'Update Practice', 'textdomain' ),
		'view_item' => __( 'View Practice', 'textdomain' ),
		'view_items' => __( 'View Practices', 'textdomain' ),
		'search_items' => __( 'Search Practice', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Practice', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Practice', 'textdomain' ),
		'items_list' => __( 'Practices list', 'textdomain' ),
		'items_list_navigation' => __( 'Practices list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Practices list', 'textdomain' ),
	),
	'menu_icon' => 'dashicons-admin-home',
	'supports' => array('title', 'thumbnail', ),
	'taxonomies' => array(),
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'menu_position' => 5,
	'show_in_admin_bar' => true,
	'show_in_nav_menus' => true,
	'can_export' => true,
	'has_archive' => true,
	'hierarchical' => false,
	'exclude_from_search' => false,
	'show_in_rest' => true,
	'publicly_queryable' => true,
	'capability_type' => 'post',
	));


    register_post_type('event', array(
	'show_in_rest' => true,
	'public' => true,
    'has_archive' => true,
	'supports' => array( 'thumbnail', 'title' ),	
	'labels' => array(
		'name' => 'Events',
		'add_new_item' => 'Add new event', 
		'edit_item' => 'Edit event',
		'all_items' => 'All events',
		'singular_name' => 'Event',
	),	
    'taxonomies' => array('event', ),
	'menu_icon' => 	'dashicons-calendar-alt',	
	'exclude_from_search' => false,
	'capability_type' => 'post',
    'rewrite' => array( 'slug' => 'events' ),    
	));
}

add_action ('init','fyldecoastccgs_post_types');

// Register Taxonomy Event Category
// Taxonomy Key: eventcategory
function create_eventcategory_tax() {

	$labels = array(
		'name'              => _x( 'Event categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Event Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Event categories', 'textdomain' ),
		'all_items'         => __( 'All Event categories', 'textdomain' ),
		'parent_item'       => __( 'Parent Event Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Event Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Event Category', 'textdomain' ),
		'update_item'       => __( 'Update Event Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Event Category', 'textdomain' ),
		'new_item_name'     => __( 'New Event Category Name', 'textdomain' ),
		'menu_name'         => __( 'Event Category', 'textdomain' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( '', 'textdomain' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
        'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => false,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
        
	);
	register_taxonomy( 'eventcategory', array('event', ), $args );

}
add_action( 'init', 'create_eventcategory_tax' );

// Register Custom Post Type YSWD
// Post Type Key: yswd
function create_yswd_cpt() {

	$labels = array(
		'name' => __( 'YSWDs', 'Post Type General Name', 'textdomain' ),
		'singular_name' => __( 'YSWD', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => __( 'YSWDs', 'textdomain' ),
		'name_admin_bar' => __( 'YSWD', 'textdomain' ),
		'archives' => __( 'YSWD Archives', 'textdomain' ),
		'attributes' => __( 'YSWD Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent YSWD:', 'textdomain' ),
		'all_items' => __( 'All YSWDs', 'textdomain' ),
		'add_new_item' => __( 'Add New YSWD', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New YSWD', 'textdomain' ),
		'edit_item' => __( 'Edit YSWD', 'textdomain' ),
		'update_item' => __( 'Update YSWD', 'textdomain' ),
		'view_item' => __( 'View YSWD', 'textdomain' ),
		'view_items' => __( 'View YSWDs', 'textdomain' ),
		'search_items' => __( 'Search YSWD', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into YSWD', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this YSWD', 'textdomain' ),
		'items_list' => __( 'YSWDs list', 'textdomain' ),
		'items_list_navigation' => __( 'YSWDs list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter YSWDs list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'YSWD', 'textdomain' ),
		'description' => __( 'You Said We Dids', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-format-chat',
		'supports' => array('title', 'thumbnail', ),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => false,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => true,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'yswd', $args );

}
add_action( 'init', 'create_yswd_cpt', 0 );

// Register Taxonomy YSWD category
// Taxonomy Key: yswdcategory
function create_yswdcategory_tax() {

	$labels = array(
		'name'              => _x( 'YSWD categories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'YSWD category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search YSWD categories', 'textdomain' ),
		'all_items'         => __( 'All YSWD categories', 'textdomain' ),
		'parent_item'       => __( 'Parent YSWD category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent YSWD category:', 'textdomain' ),
		'edit_item'         => __( 'Edit YSWD category', 'textdomain' ),
		'update_item'       => __( 'Update YSWD category', 'textdomain' ),
		'add_new_item'      => __( 'Add New YSWD category', 'textdomain' ),
		'new_item_name'     => __( 'New YSWD category Name', 'textdomain' ),
		'menu_name'         => __( 'YSWD category', 'textdomain' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'YSWD Taxonomy', 'textdomain' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => false,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'yswdcategory', array('yswd', ), $args );

}
add_action( 'init', 'create_yswdcategory_tax' );

// Register Custom Post Type Job
// Post Type Key: job
function create_job_cpt() {

	$labels = array(
		'name' => __( 'Jobs', 'Post Type General Name', 'textdomain' ),
		'singular_name' => __( 'Job', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => __( 'Jobs', 'textdomain' ),
		'name_admin_bar' => __( 'Job', 'textdomain' ),
		'archives' => __( 'Job Archives', 'textdomain' ),
		'attributes' => __( 'Job Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Job:', 'textdomain' ),
		'all_items' => __( 'All Jobs', 'textdomain' ),
		'add_new_item' => __( 'Add New Job', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Job', 'textdomain' ),
		'edit_item' => __( 'Edit Job', 'textdomain' ),
		'update_item' => __( 'Update Job', 'textdomain' ),
		'view_item' => __( 'View Job', 'textdomain' ),
		'view_items' => __( 'View Jobs', 'textdomain' ),
		'search_items' => __( 'Search Job', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Job', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Job', 'textdomain' ),
		'items_list' => __( 'Jobs list', 'textdomain' ),
		'items_list_navigation' => __( 'Jobs list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Jobs list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Job', 'textdomain' ),
		'description' => __( 'Jobs on the Fylde Coast', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-universal-access-alt',
		'supports' => array('title', 'thumbnail', ),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'job', $args );

}
add_action( 'init', 'create_job_cpt', 0 );

// Register Taxonomy Job Category
// Taxonomy Key: jobcategory
function create_jobcategory_tax() {

	$labels = array(
		'name'              => _x( 'Job Cateegories', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Job Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Job Cateegories', 'textdomain' ),
		'all_items'         => __( 'All Job Cateegories', 'textdomain' ),
		'parent_item'       => __( 'Parent Job Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Job Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit Job Category', 'textdomain' ),
		'update_item'       => __( 'Update Job Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New Job Category', 'textdomain' ),
		'new_item_name'     => __( 'New Job Category Name', 'textdomain' ),
		'menu_name'         => __( 'Job Category', 'textdomain' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Categories for Jobs', 'textdomain' ),
		'hierarchical' => false,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_rest' => false,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
	);
	register_taxonomy( 'jobcategory', array('job', ), $args );

}
add_action( 'init', 'create_jobcategory_tax' );
?>