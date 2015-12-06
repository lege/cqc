<?php if( dopt('d_adindex_02_b') ) printf('<div class="banner banner-sticky">'.dopt('d_adindex_02').'</div>'); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="diag"></div>
<article class="excerpt">
	<ul class="focus">
<li class="metatime"><?php if(is_home()) the_time('Y.m.d'); else the_time('Y-m-d'); ?></li>
<li class="metacomt"><?php 
				if ( comments_open() ) echo '<a href="'.get_comments_link().'">'.get_comments_number('0', '1', '%').'&nbsp;Comments</a>';
			?></li>
<li class="metaview"><?php deel_views('&nbsp;Views'); ?></li>
<li class="metacateblack-color"><?php the_category(‘, ‘) ?></li>
<li class="metaauthor"><?php if( !is_author() ){ ?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php echo get_the_author() ?></a><?php } ?></li>	
</ul>
	<div class="hl_excerpt">
		<header>
			<h3 style=" font-weight: normal; font-size: 16px; "><a target="_blank" href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php bloginfo('name'); ?>"><?php the_title(); ?></a></h3>
		</header>
		<p class="note"><?php echo deel_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 160, '...'); ?></p>
			<p>
		</p>
	</div>
</article>
<?php endwhile; wp_reset_query(); ?>
<?php deel_paging(); ?>