<?php

/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */
get_header(); ?>
<?php get_header('masthead'); ?>
<div id="main" class="container" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">		
	<div class="row">
			<?php 
				while ( have_posts() ) : the_post();
					get_template_part('content');
				endwhile; // end of the loop. 
				dmeng_paginate();
			?>
		<?php get_sidebar();?>
	</div>
 </div><!-- #main -->
<?php get_footer('colophon'); ?>
<?php get_footer(); ?>
