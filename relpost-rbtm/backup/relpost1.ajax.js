/**
 * AJAX script for Go Further
 */

(function($){
    // $('body').click(function(event){
    //    console.log(event.target);
    //    var xxx=1;
    // });
    // RBTMz1;

    $('#related-posts').on( 'click','a.get-related-posts', function( event) {
        event.preventDefault();
        var $relatedPost = $('#related-posts');
        console.log('$this:',(this));
//        if ($(this).data('pagenum')===undefined){
        if ($('#related-posts').data('pagenum')===undefined){
           var pagenum = 1;
           $relatedPost.append('<h1 class="related-header">Related Posts:</h1>');
        } else {
           if (pagenum = 1) {}
           var pagenum =  parseInt($('#related-posts').data('pagenum'));
               ++pagenum;
//               $('#related-posts').empty();
               // $relatedPost.find('aside.related-post').remove();
        }

        var $ajaxLoader = $('.ajax-loader');
        // Remove "Get Related Posts" button
        $('a.get-related-posts').remove();
//        $('a.get-related-posts').hide();
        // Display loader
       $ajaxLoader.show();

        // Get REST URL and post ID from WordPress
        var json_url = postdata.json_url;
        var post_id = postdata.post_id;
//        var baze_url = "http://site1.net/";

        json_url += '&page=' + pagenum.toString();
//        json_url = baze_url + "wp-json/wp/v2/posts";

        $.ajax({
            dataType: 'json',
            method: 'GET',
            url: json_url,
            success: function(data, textStatus, jqXHR){
//                console.log('X-WP-Total: ',jqXHR.getResponseHeader('X-WP-Total'));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // console.log(request);
                console.log('jqXHR: ', jqXHR);
                console.log('textStatus: ', textStatus);
                console.log('errorThrown: ', errorThrown);
            }

        })

        .done(function(data, textStatus, jqXHR){
            console.log('X-WP-Total: ',jqXHR.getResponseHeader('X-WP-TotalPages'));
            console.log('cur_page: ',pagenum);
            // Display "Related Posts:" header

            // Loop through each of the related posts
            $relatedPost.find('aside.related-post').remove();
            $.each(data, function(index, object) {
                if (object.id == post_id) { // if same id, don't display
                    return;
                }
                // initialize
                var feat_img = '',
                    opt_img = '',
                    opt_author = '',
                    opt_excerpt = '';

                 //get direct Rest API
   //               opt_img =    '<img src="' + object._embedded['wp:featuredmedia'][0].media_details.sizes.thumbnail.source_url + '" alt="">';
   //               opt_author = '<div class="related-author">by <em>' + object._embedded.author[0].name + '</em></div>';
   //               opt_excerpt = '<p class=\"entry-summary\">' + object.excerpt.rendered + '</p>';

                 //get registered Rest API

//              if (typeof  object.featured_media !== "undefined" ) {
                if (object.featured_media !== 0 ) {
                   opt_img =    '<img src="' + object.featured_image_src + '" alt="">';
                }

                if (object.excerpt_pst) {
                    opt_excerpt = '<p class=\"entry-summaryz\">' + object.excerpt_pst + '</p>';
                }

                opt_author = '<div class="related-author">by <em>' + object.author_name + '</em></div>';

//                if (object._links['wp:featuredmedia'][0].embeddable) {

                feat_img =      '<figure class="related-featured">' +
                                     opt_img +
                                    '</figure>';

                // Set up HTML to be added
                var related_loop =  '<aside class="related-post clear">' +
                                    '<a href="' + object.link + '">' +
                                    '<h1 class="related-post-title">' + object.title.rendered + '</h1>' +
                                     '</a>' +
                                    opt_author +
                                    '<div class="related-excerpt">' +
                                    feat_img + opt_excerpt +
                                    '</div>' +
                                    '</aside><!-- .related-post -->';

                // Hide loader

               $ajaxLoader.hide();
                // Append HTML to existing content

                $relatedPost.append(related_loop);

                //------------- load button to next related post

            });
            $relatedPost.append( '<a href="#" class="get-related-posts">Show next related posts</a>');
//            $relatedPost.append( 'a.get-related-posts').text('Show next related posts').show();
//            $('a.get-related-posts').data("pagenum",pagenum.toString());
            if (pagenum >= parseInt(jqXHR.getResponseHeader('X-WP-TotalPages'))) {
                pagenum = 0;
            }
           $relatedPost.data("pagenum",pagenum.toString());
//           alert($relatedPost.data("pagenum"));
            $relatedPost.append($ajaxLoader);
             //.appendTo($ajaxLoader);
        })

        .fail(function(jqXHR, textStatus, errorThrown){
            // Hide loader
           $ajaxLoader.remove();
            // If something goes wrong, say so
            $('#related-posts').append('<div>Something went wrong</div>');
//            console.log('Error');
        })

        .always(function(){
//            console.log('AJAX Complete!');
        });

    });
})(jQuery);
