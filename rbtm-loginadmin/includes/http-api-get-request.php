<?php

//example: GET request
function loginadmin_http_get_request($url) {
   $url = esc_url_raw( $url);
   $args = array('user-agent' => 'Plugin Demo: HTTP API;'.home_url());
   return wp_safe_remote_get($url, $args);
}

// GET response
function loginadmin_http_get_response() {
  $url = 'https://api.github.com';
   // $url = 'https://api.github.com/gists/public';
   $response = loginadmin_http_get_request($url);
//   echo '<pre>rbtm dump: ';
//   var_dump($response);
//   echo '</pre>';
//   die();
   //response data
   $code = wp_remote_retrieve_response_code( $response );
   $message = wp_remote_retrieve_response_message( $response );
   $body = wp_remote_retrieve_body( $response );
   $headers = wp_remote_retrieve_headers( $response );

   // List of HTTP header fields - https://en.wikipedia.org/wiki/List_of_HTTP_header_fields
   $header_date = wp_remote_retrieve_header( $response, 'date' );
   $header_type = wp_remote_retrieve_header( $response, 'content-type' );
   $header_cache = wp_remote_retrieve_header( $response, 'cache-control' );


   //output data
   $output = '<h2>HTTP API Response GET - Status RBTM</h2>';
   $output .= '<h2><code>'. $url .'</code></h2>';
   $output .='<div>Response code: '.$code.'</div>';
   $output .='<div>Response message: '.$message.'</div>';

   $output .= '<h3>Body</h3>';
   $output .= '<pre>';
   ob_start();
   var_dump($body);
   $output .= ob_get_clean();
   $output .= '</pre>';

   $output .= '<h3>Headers </h3>';
   $output .= '<div>Response Date: '.$header_date.' </div>';
   $output .= '<div>Content Type: '.$header_type.' </div>';
   $output .= '<div>Cache Control: '.$header_cache.' </div>';
   $output .= '<pre>';
   ob_start();
   var_dump($headers);
   $output .= ob_get_clean();
   $output .= '</pre>';

   return $output;

}


// POST request
function loginadmin_http_post_request($url) {
    $url = esc_url_raw($url);
    $body = array(
        'name' => 'Bruce Wayne',
        'email' => 'user@example.com',
        'subject' => 'Subj: Message From Contact Form',
        'comment' => 'Hello, nice to meet someone!',
        
    );
    
    $args = array ('body' => $body,);
    
    return wp_safe_remote_post($url, $args);
}

// POST Response

function  loginadmin_http_post_response() {
    $url = 'http://httpbin.org/post';
    
    $response = loginadmin_http_post_request($url);
    
    // response data
    
    $code = wp_remote_retrieve_response_code($response);
    $message = wp_remote_retrieve_response_message($response);
    $body = wp_remote_retrieve_body($response);
    $headers = wp_remote_retrieve_headers($response);
    
    $header_date = wp_remote_retrieve_header($response, 'date');
    $header_type = wp_remote_retrieve_header($response, 'content-type');
    $header_server = wp_remote_retrieve_header( $response, 'server' );
    
    // output data

   $output = '<h2>HTTP API Response POST - Status RBTM</h2>';
   $output .= '<h2><code>'. $url .'</code></h2>';
   $output .='<div>Response code: '.$code.'</div>';
   $output .='<div>Response message: '.$message.'</div>';

   $output .= '<h3>Body</h3>';
   $output .= '<pre>';
   ob_start();
   var_dump($body);
   $output .= ob_get_clean();
   $output .= '</pre>';

   $output .= '<h3>Headers </h3>';
   $output .= '<div>Response Date: '.$header_date.' </div>';
   $output .= '<div>Content Type: '.$header_type.' </div>';
   $output .= '<div>Cache Control: '.$header_server.' </div>';
   $output .= '<pre>';
   ob_start();
   var_dump($headers);
   $output .= ob_get_clean();
   $output .= '</pre>';

   return $output;
}