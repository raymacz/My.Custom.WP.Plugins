<?php
//global $wpdb


//select a variable ex.1
function loginadmin_db_get_user_count() {
  global $wpdb;
  $query = "SELECT COUNT(*) FROM $wpdb->users";
  $results = $wpdb->get_var($query);
  echo '<h2> WPDB Wordpress Database</h2>';
  echo '<h3> Test #01: </h3>';
  //display the results
  if (null !== $results) {
    echo '<div> Numbers of users: '.$results.'</div>';
  } else {
    echo '<div> No results.</div>';
  }
}


//select a variable ex.2
function loginadmin_db_sum_custom_fields() {
  global $wpdb;
//  $meta_key = 'minutes';
  $meta_key = '_thumbnail_id';
  $query = "SELECT sum(meta_value) FROM $wpdb->postmeta WHERE meta_key = %s";
  $prepared_query = $wpdb->prepare($query, $meta_key);
  $results = $wpdb->get_var($prepared_query);
  echo '<h3> Test #02: </h3>';
  //display the results
  if ( null !== $results) {
    $str = "<div>  Total Sum of Meta Values with Meta key of \\{$meta_key}\\  : {$results}</div>";
    $str = str_replace('\\','\'', $str);
    echo $str;
  } else {
    echo '<div> No results.</div>';
  }
}

//select a row ex.3
function loginadmin_db_get_primary_admin() {
  global $wpdb;
  $user_id = 1;
  $query = "SELECT * FROM $wpdb->users WHERE ID = %d";
  $prepared_query = $wpdb->prepare($query,$user_id);
  $user = $wpdb->get_row($prepared_query);
  echo '<h3> Testz #03: </h3>';

  //display the results
  if ( null !== $user) {
    echo '<div> Primary Admin User: </div>';
    echo '<pre> ';
    var_dump($user);
    echo '</pre>';

    echo '<div> User ID: '.$user->ID.'</div>';
    echo '<div> User Login: '.$user->user_login.'</div>';
    echo '<div> User Email: '.$user->user_email.' </div>';
  } else {
    echo '<div> No results.</div>';
  }
}

//select a column ex.4
function loginadmin_db_get_all_users_ids() {
  global $wpdb;
  $query = "SELECT ID FROM $wpdb->users";
  $results = $wpdb->get_col($query);
  echo '<h3> Test #04: </h3>';
  //display the results
  if ( null !== $results) {
    echo '<div> All user IDs:</div>';
    echo '<pre> ';
    var_dump($results);
    echo '</pre>';
  } else {
    echo '<div> No results.</div>';
  }
}


//select generic results ex.5
function loginadmin_db_get_draft_posts() {
  global $wpdb;
  $post_author = 1;
  $query = "SELECT ID, post_title FROM $wpdb->posts 
  WHERE post_status = 'draft'
  AND post_type = 'page'
  AND post_author = %s";
  // check posts table
  $prepared_query = $wpdb->prepare($query, $post_author);
  $draft_posts = $wpdb->get_results($prepared_query);
  echo '<h3> Test #05: </h3>';
  //display the results
  if ( null !== $draft_posts) {
    echo '<div> All user IDz:</div>';
    echo '<pre> ';
    var_dump($draft_posts);
    echo '</pre>';
    echo '<p>Draft post titles:  </p>';

    foreach($draft_posts as $draft_post) {
        echo '<div> '.$draft_post->post_title.' </div>';
    }

  } else {
    echo '<div> No results.</div>';
  }

}


// running general queries ex.6
function loginadmin_db_add_custom_field() {
  global $wpdb;
  $post_id = 1;
  $meta_key = 'favorite-season';
  $meta_value= 'Autumn';
  $result = 0;
  $query = "INSERT INTO $wpdb->postmeta(post_id, meta_key, meta_value) VALUES(%d, %s, %s)"; // check postmeta table
  $prepared_query = $wpdb->prepare($query, $post_id, $meta_key, $meta_value);
//   $result = $wpdb->query($prepared_query); // uncomment this to execute query 
   // duplicate meta key will still be added
echo '<h3> Test #06: </h3>';
  //display the results
  echo '<div>Add custom field: ';
  if (false === $result) echo 'There was an error.';
  elseif (0 === $result ) echo 'No results.';
  else echo 'The custom field was added.';
  echo '</div>';
}
