<?php

/**
* Plugin Name: Wordpress Assorted WP Filters
* Description: Assorted Filters Examples Sandbox
* 1. Allows the user to see relevant articles that are within the category.
* 2. Email the post author if there is a new comment added
* 3. Change the case for every title.
* 4. Change header URL
* Version: 0.1.0
* Author: Raymacz
* Author URI: http:webmacz.ml
* Text Domain: rbtm
* License: GPL2+
*
*/
error_reporting(E_ALL); //during developement, add this to help in making WP plugins

// If this file is called directly, abort
if ( !defined('ABSPATH') ) {
	die;
}

//TutsPlus - WordPress Plugin Development Essentials

// 1. Allows the user to see relevant articles that are within the category. ==================================

// filter the content & do something
add_filter('the_content', function($content){
    $id = get_the_ID();
    if (!is_singular('post')) {
//        var_dump($content);
        return $content;
    }
    // extract the ID only
    $terms = get_the_terms($id, 'category');
//    print_r($terms);
    $term_ids = array();
    foreach ($terms as $term) {
//        print_r($term);
//        echo $term->term_id;
        $term_ids[] = $term->term_id;
    }
//  query all posts based on the IDs
    $loop = new WP_Query(
                array(
                 'cat' => $term_ids,
                 'post_per_page' =>  3,

                )
            );
    // add the title in every content
    if ($loop->have_posts()) {
        $content .= "<h2> Just Related Posts </h2>"
               . '<ul class="rel-cat-posts">';

        while ($loop->have_posts()) {
            $loop->the_post();

            $content .= '<li>'
                        .'<a href="'. get_permalink().'">'. get_the_title().'</a>'
                        . '</li>';
        }
        $content .='</ul>';
        wp_reset_query();
    }
    return $content;
});

// 2. email the post author if there is a new comment added  ===============================
	 
add_action( 'comment_post', 'rbtm_email_if_comment');

  function rbtm_email_if_comment()
	 {
	 	$email = get_bloginfo('admin_email'); // get the admin email
                $subject = "New Comment Posted";
                $message = "A new comment has been added to your post.";
              //   wp_mail($email, $subject, $message);
//                echo "<pre> Plugin Notification: a comment is added </pre>";
	 }

//      3. Change the case for every title.   ===========================================

 // just a test to change title with admin email.
//add_filter( 'the_title', 'rbtm_change_title', 12, 2);  
function rbtm_change_title($title, $id) {
    if ($id == 1945) {
        return get_bloginfo('admin_email');
     }   
    return $title;
}           
         
//         Uppercase the first character of each word in a string
//add_filter('the_title', ucwords); 
add_filter('the_title', function($content) {
//    echo "Plugin Notification: Title Uppercase!";
    return ucwords($content);
//    return $content;
}); 

//      4. Change header URL   ===========================================

function change_header_url($url) {
  print $url;
  $url = 'http://mqassist.ml';
  global $myurl; 
  $myurl = $url;
   //return $url;
   return get_bloginfo( 'url' );
}

add_filter('login_headerurl', 'change_header_url');
         
?>
