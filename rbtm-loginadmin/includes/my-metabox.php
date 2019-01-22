<?php

//register meta box
function loginadmin_add_meta_box() {
  $post_types = array ('post', 'page', 'review');
  foreach ($post_types as $post_type) {
    add_meta_box(
      'loginadmin_meta_box', //unique metabox ID
      'LoginAdmin Meta Box', // Title of metabox
      'loginadmin_display_meta_box', //Callback Function
      $post_type //Post type
    );
  }
}
 add_action( 'add_meta_boxes', 'loginadmin_add_meta_box' );


//display meta box
function loginadmin_display_meta_box( $post ) {
  $value= get_post_meta( $post->ID, '_loginadmin_meta_key', true ); //underscore meta key means it will be hidden on frontend
  wp_nonce_field( basename(__FILE__), 'loginadmin_meta_box_nonce' ); // for WP security
     echo '<pre>rbtm dumpz getpostmeta: ';
      var_dump($value);
     echo '</pre>';
//     die();
  ?>
    <!-- #myid.wrap.myclass[title="titlename"]>ul>(li#myid$$>span.style>a[href="#"]{mytext$$})*3+br -->

    <label for="loginadmin-meta-box">Field Description</label>
    <select name="loginadmin-meta-box" id="loginadmin-meta-box">
      <option value="">Select option...</option>
      <option value="options-1" <?php selected($value, 'options-1');?>>Option 1</option>
      <option value="options-2" <?php selected($value, 'options-2');?>>Option 2</option>
      <option value="options-3" <?php selected($value, 'options-3');?>>Option 3</option>
    </select>

      <!--ctrl+e-->
  <?php
  }

  //when user saves meta box
  function loginadmin_save_meta_box($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id ); // if its an autosave post
    $is_revision = wp_is_post_revision( $post_id ); // if its a revision post
    $is_valid_nonce=false;

    if (isset($_POST['loginadmin_meta_box_nonce'])) {
      if ( wp_verify_nonce( $_POST['loginadmin_meta_box_nonce'], basename(__FILE__) )) {
          $is_valid_nonce = true;
      }
    }

    if($is_autosave || $is_revision || !$is_valid_nonce) return;

    if (array_key_exists('loginadmin-meta-box',$_POST)) {
     echo '<pre>rbtm dumpz: ';
      var_dump($_POST['loginadmin-meta-box']);
     echo '</pre>';
//     die();
       update_post_meta( $post_id, '_loginadmin_meta_key', sanitize_text_field( $_POST['loginadmin-meta-box'] ) ); //should match the key above
    }

  }
  add_action( 'save_post','loginadmin_save_meta_box');
