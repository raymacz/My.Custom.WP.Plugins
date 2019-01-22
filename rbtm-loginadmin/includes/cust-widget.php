<?php

/*
 * Loginadmin - Clean Markup Custom Widget
 */

class Clean_Markup_Widget extends WP_Widget {

    //setup widget
    public function __construct() {
        $id ='clean_markup_widget';
        $title = esc_html__('Clean Markup Widget', 'loginadmin');
        $options = array (
          'classname'   => 'clean-markup-widget',
          'description' => esc_html__('Add clean markup that is not Wordpress modified.', 'loginadmin'),
        );

        parent::__construct($id, $title , $options);
    }

    //outputs inputted markup widget content to the front-end
    public function widget($args, $instance) {

//        echo '<pre>rbtm instance: ';
//        var_dump($instance);
//        echo 'args';
//        var_dump($args);
////        die();
//        echo '</pre>';

        //extract ($args); //uncomment this to customize display of markup
        $markup = '';
        if (isset($instance['markup'])){
            echo wp_kses_post($instance['markup']);
        }
    }

    //process options //  triggered when the admin - widget form is being inputted and saved
    public function update($new_instance, $old_instance) {
        // echo '<pre>rbtm new_instance: ';
        // var_dump($new_instance); // newly inputted
        // echo 'old_instance: ';
        // var_dump($old_instance); // previously inputted
        // die();
        // echo '</pre>';
        $instance = array();
        if(isset($new_instance['markup']) && !empty($new_instance['markup'])) {
            $instance['markup'] = $new_instance['markup'];
        }
        return $instance;
    }

    //outputs widget form fields in the WP admin    
    public function form($instance) {
//      echo '<pre>rbtm instance: ';
//      var_dump($instance); // newly inputted
////      die();
//      echo '</pre>';
        $id = $this->get_field_id('markup');
        $for = $this->get_field_id('markup');
        $name = $this->get_field_name('markup');
        $label = __('Markup/text:', 'loginadmin');
        //default form content
        $markup = '<p>'. __('Cleanup markup.','loginadmin').'</p>';

        if(isset($instance['markup']) && !empty($instance['markup'])) {
            $markup = $instance['markup'];
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($for); ?>"><?php echo esc_html($label); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>">
            <?php echo esc_textarea($markup); ?> </textarea>
        </p>
        <?php
    }


};

 //register widget
function loginadmin_register_widgets() {
    register_widget('Clean_Markup_Widget');
}
add_action('widgets_init', 'loginadmin_register_widgets');
echo '';
