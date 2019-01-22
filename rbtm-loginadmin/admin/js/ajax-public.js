/*
 * Ajax. - Javascript for Admin Area
 */

(function($) {
        $(document).ready(function() {
            //when user submits a form
            $('#get-data>a').on('click', function(event) {
              event.preventDefault();
              //add loading message
              $('.ajax-response').html('Loading...');
              //define url
//              var url = $('#url').val();
              var myid = $('#get-data>a').data('id');
              //submit the data
              // ajaxurl - is automatically added/initialized by Worpresss - https://www.screencast.com/t/AdY7JkgCkOk
              // ajax.admin.nonce = nonce value passed from wp_localize_script() from my-ajax.php
              $.post(ajax_public.ajaxurl, {
                nonce: ajax_public.nonce,
                ajaxurl: ajax_public.ajaxurl,
                action: 'public_hook',
//                id: url
                author_id: myid
              }, function(data) {
                 //log data
                 console.log(data);
                 //display data
                 $('.ajax-response').html(data);
              });
            });

        });
 })(jQuery);
