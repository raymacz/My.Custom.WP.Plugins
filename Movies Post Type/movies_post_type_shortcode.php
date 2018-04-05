<?php

add_shortcode('jw_movies', function() {
	$loop = new WP_Query(
		array(
			'post_type' => 'jw_movie',
			'order_by' => 'title'
		)
	);
	
	if($loop->have_posts()) {
		$output = '<ul class="jw_movie_list">';
		while ($loop->have_posts()) {
			$loop->the_post();
			$meta = get_post_meta(get_the_id(), ''); //this can be broken into individual information
			//print_r($meta);
			//$mymeta="1:25";
			//if (isset($meta['jw_movie_length'][0])) {
			//	$mymeta= $meta['jw_movie_length'][0];
			//}
		//	$output.='<li href="'.get_permalink().'"><a>'.get_the_title().' | '.$mymeta.'</a><div>'.get_the_excerpt().'</div></li>';
			$output.='<li href="'.get_permalink().'"><a>'.get_the_title().' | '.$meta['jw_movie_length'][0].'</a><div>'.get_the_excerpt().'</div></li>';
			
		}
		$output.='</ul>';
		return $output;
	} else {
		$output = 'No movies added!';
	}
	return $output;
});

?>