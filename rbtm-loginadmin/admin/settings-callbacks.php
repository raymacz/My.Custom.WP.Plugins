<?php

/*
 * loginadmin -  Validate Settings
 */

// exit if file is called directly
if ( ! defined ('ABSPATH')) {
   exit;
}


//callback: login section
function loginadmin_callback_section_login() {
    echo "<p>These settings enable you to customize the WP Login screen.";
}

//callback: admin section
function loginadmin_callback_section_admin() {
    echo "<p>These settings enable you to customize the WP Admin screen.";
}




//callback: radio field
function loginadmin_callback_field_radio($args) {
    //todo: add callback functionality... //  echo 'this will be a radio field';
    $options = get_option('loginadmin_options', loginadmin_options_default());
    $id    = isset ($args['id'])? $args['id'] : '';
    $label = isset ($args['label'])? $args['label'] : '';
    $selected_option = isset ($options[$id]) ? sanitize_text_field($options[$id]) :'';

    $radio_options = array(
         'enable' => 'Enable custom styles',
         'disable' => 'Disable custom styles',
    );

    foreach ( $radio_options as $value => $label) {
        $checked = checked($selected_option === $value, true, false);
        echo '<label><input  name="loginadmin_options['.$id.']" type="radio" value="'.$value.'"'.$checked.'> ';
        echo '<span>'.$label.'</span></label><br />';
    }

}

//callback: textarea field
function loginadmin_callback_field_textarea($args) {
    //todo: add callback functionality... //    echo 'this will be a textarea field';

    $options = get_option('loginadmin_options', loginadmin_options_default());
    $id    = isset ($args['id'])? $args['id'] : '';
    $label = isset ($args['label'])? $args['label'] : '';

    $allowed_tags = wp_kses_allowed_html('post');

    $value = isset( $options[$id]) ? wp_kses(stripslashes_deep($options[$id]), $allowed_tags) :'';

//    foreach ( $radio_options as $value => $label) {
//        $checked = checked($selected_option === $value, true, false);
//        echo '<label><input  name="loginadmin_options['.$id.']" type="radio" value="'.$value.'"'.$checked.'> ';
//        echo '<span>'.$label.'</span></label><br />';
//    }
//
    echo '<textarea id="loginadmin_options_'.$id.'" name="loginadmin_options['.$id.']"  rows="5" cols="50">'.$value.'</textarea><br />';
    echo '<label for="loginadmin_options_'.$id.'">'.$label.'</label>';
}

//callback: text field
function loginadmin_callback_field_text($args) {
    //todo: add callback functionality... //    echo 'this will be a text field';
    $options = get_option('loginadmin_options', loginadmin_options_default()); //  $options_name

//    $options = loginadmin_options_default();

    $id    = isset ($args['id'])? $args['id'] : ''; // settings-register.php  add_settings_field()
    $label = isset ($args['label'])? $args['label'] : ''; // settings-register.php  add_settings_field()
    $value = isset ($options[$id]) ? sanitize_text_field($options[$id]) :'';

    echo '<input id="loginadmin_options_'.$id.'" name="loginadmin_options['.$id.']" type="text" size="40" value="'.$value.'"><br />';
    echo '<label for="loginadmin_options_'.$id.'">'.$label.'</label>';

}

//callback: checkbox field
function loginadmin_callback_field_checkbox($args) {
    //todo: add callback functionality... // echo 'this will be a checkbox';
    $options = get_option('loginadmin_options', loginadmin_options_default()); //  $options_name
    $id    = isset ($args['id'])? $args['id'] : ''; // settings-register.php  add_settings_field()
    $label = isset ($args['label'])? $args['label'] : ''; // settings-register.php  add_settings_field()
    $checked = isset ($options[$id]) ? checked( $options[$id],1,false) : '';

    echo '<input id="loginadmin_options_'.$id.'" name="loginadmin_options['.$id.']" type="checkbox"  value="1"'.$checked.'>';
    echo '<label for="loginadmin_options_'.$id.'">'.$label.'</label>';
}

//callback: select field
function loginadmin_callback_field_select($args) {
    //todo: add callback functionality... //    echo 'this will be a select menu';

    $options = get_option('loginadmin_options', loginadmin_options_default()); //  $options_name
    $id    = isset ($args['id'])? $args['id'] : ''; // settings-register.php  add_settings_field()
    $label = isset ($args['label'])? $args['label'] : ''; // settings-register.php  add_settings_field()

    $selected_option = isset ($options[$id]) ? sanitize_text_field($options[$id]) :'';

    $select_options = array(
        'default' => 'Default',
        'light' => 'Light',
        'blue' => 'Blue',
        'coffee'    => 'Coffee',
        'ectoplasm' => 'Ectoplasm',
        'midnight' => 'Midnight',
        'ocean' => 'Ocean',
        'sunrise' => 'Sunrise',
    );

//     echo '<select id="loginadmin_options_'.$id.'" name="loginadmin_options['.$id.']" type="checkbox"  value="1"'.$checked.'>';
    echo '<select id="loginadmin_options_'.$id.'" name="loginadmin_options['.$id.']">';

    foreach ( $select_options as $value => $option) {
        $selected = selected($selected_option === $value, true, false);
        echo '<option value="'.$value.'"'.$selected.'>'.$option.'</option>';
    }
    echo '</select><label for="loginadmin_options_'.$id.'">'.$label.'</label>';
}
