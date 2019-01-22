/*
 * Ajax. - Javascript for Admin Area
 */

(function($) {
        $(document).ready(function() {
            //when user submits a form
            $('.ajax-form').on('submit', function(event) {
              event.preventDefault();
              //add loading message
              $('.ajax-response').html('Loading...');
              //define url
              var url = $('#url').val();
              //submit the data
              // ajaxurl - is automatically added/initialized by Worpresss - https://www.screencast.com/t/AdY7JkgCkOk
              // ajax.admin.nonce = nonce value passed from wp_localize_script() from my-ajax.php
              $.post(ajaxurl, {
                nonce: ajax_admin.nonce,
                action: 'admin_hook',
                url: url
              }, function(data) {
                 //log data
                 console.log(data);
                 //display data
                 $('.ajax-response').html(data);
              });
            });

        });
 })(jQuery);
