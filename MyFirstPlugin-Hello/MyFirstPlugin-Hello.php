<?php

/**
*
* Plugin Name: MyFirstPlugin Hello
*/



function change_header_url($url) {
  print $url;
  $url = 'http://mqassist.ml';
  global $myurl; 
  $myurl = $url;
   //return $url;
   return get_bloginfo( 'url' );
}

add_filter('login_headerurl', 'change_header_url');

function hello_world() {
  //print "Hello World! This is my first WP Plugin... Cheers!!! ";
  print "Hello World! This is my first WP Plugin... Cheers!!! ".$myurl;
}
add_action('login_header', 'hello_world');










?>