/**
 * AJAX script for Go Further
 */

(function($){
    // $('body').click(function(event){
    //    console.log(event.target);
    //    var xxx=1;
    // });
    // RBTMz1;

   var Relpost = {
     init: function() {
       this.cache(); // my own method
       // Get REST URL and post ID from WordPress
       this.json_url = postdata.json_url;
       this.post_id = postdata.post_id;
       // this.pagenum = 5;
       this.bindEvents(); // my own method
     },

     cache: function() {
       this.$relatedPost = $('#related-posts');
       this.Onchild= 'a.get-related-posts';
       this.$getRelPost= $('a.get-related-posts');
       this.$ajaxLoader= $('.ajax-loader');

     },

     pagenumNow: function() {
       var self = Relpost;
       if (self.$relatedPost.data('pagenum')===undefined){
          self.pagenum = 1;
          self.$relatedPost.append('<h1 class="related-header">Related Posts:</h1>');
       } else {
          self.pagenum =  parseInt(self.$relatedPost.data('pagenum'));
              ++self.pagenum;
       }
     },

     bindEvents: function() {
       var self = Relpost;
       self.$relatedPost.on('click',self.Onchild, this.prepDisplay);

     },

     prepDisplay: function(event) {
       var input = this,
           self = Relpost;
       event.preventDefault();
       self.pagenumNow();
       // console.log('event: ',event);
       // console.log('this-pagenumNow: ', self.pagenum);
       // console.log('Onchild: ', self.$getRelPost);
       // console.log('this: ', input);
       // self.$getRelPost.remove();
       input.remove();
       self.$ajaxLoader.show();
       self.json_url += '&page=' + self.pagenum.toString();
       console.log('json_url: ', self.json_url);
       self.fetchJSON();
     },

     fetchJSON: function() {

       $.ajax({
           dataType: 'json',
           method: 'GET',
           url: Relpost.json_url,
           success: function(data, textStatus, jqXHR){
                console.log('X-WP-Total: ',jqXHR.getResponseHeader('X-WP-Total'));
           },
           error: function (jqXHR, textStatus, errorThrown) {
               console.log('jqXHR: ', jqXHR);
               console.log('textStatus: ', textStatus);
               console.log('errorThrown: ', errorThrown);
           }

       })

       .done(function(data, textStatus, jqXHR){
         var self = Relpost;
         self.renderResults(data, textStatus, jqXHR); // my own method
         })
         .fail(function(jqXHR, textStatus, errorThrown){
         })
         .always(function() {
  		    console.log( "complete execution" );
    		 });
     },

     renderResults: function(data, textStatus, jqXHR) {
       var self = Relpost;
         self.$relatedPost.find('aside.related-post').remove();
         console.log( "Da: ", data  );
         console.log( "Te: ", textStatus  );
         console.log( "Jq: ", jqXHR  );
         var frag ='';
         $.each(data, function(index, object) {
             if (object.id == self.post_id) { // if same id, don't display
                 return;
             }

            frag = '<aside class="related-post clear">';
            frag += '<a href="' + object.link + '">';
            frag += '<h1 class="related-post-title">' + object.title.rendered + '</h1>';
            frag += '</a>';
            frag += '<div class="related-author">by <em>' + object.author_name + '</em></div>';
            frag += '<div class="related-excerpt">';
            frag += '<figure class="related-featured">';
            if (object.featured_media !== 0 ) {
               frag+= '<img src="' + object.featured_image_src + '" alt="">';
            }
            frag += '</figure>';
            if (object.excerpt_pst) {
               frag+= '<p class=\"entry-summaryz\">' + object.excerpt_pst + '</p>';
            }
            frag += '</div>';
            frag += '</aside><!-- .related-post -->';
            self.$ajaxLoader.hide();
            self.$relatedPost.append(frag);

        });
        self.$relatedPost.append( '<a href="#" class="get-related-posts">Show next related posts</a>');
        if (self.pagenum >= parseInt(jqXHR.getResponseHeader('X-WP-TotalPages'))) {
            self.pagenum = 0;
        }
        self.$relatedPost.data("pagenum",self.pagenum.toString());
//           alert($relatedPost.data("pagenum"));
        self.$relatedPost.append(self.$ajaxLoader);
             // Hide loader
     }
   };


    window.Relpost = Relpost.init();


})(jQuery);
