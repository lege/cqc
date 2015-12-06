<div class="sticky">
	<ul>
	<?php $sticky = get_option('sticky_posts'); rsort( $sticky );
		query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1, 'showposts' => dopt('d_sticky_count')?dopt('d_sticky_count'):1 ) );
		while (have_posts()) : the_post(); 

		echo '<li class="item"><a class="item-image" href="'.get_permalink().'">';
		echo deel_thumbnail();

		echo '</a><div class="huilang_stick"><a class="item-h2" href="'.get_permalink().'"><h2 style=" font-weight: normal; ">'.get_the_title().'</h2></a><p class="muted">'.deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 141, '...').'</p></div>';

		echo '</li>';

		endwhile; 
		wp_reset_query(); 
	?>
	</ul>
</div>