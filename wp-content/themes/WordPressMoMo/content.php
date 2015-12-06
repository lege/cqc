<?php
/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦
 */
?>
<article id="content" class="col-lg-8 col-md-8 single" data-post-id="<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/Article">
	<div>
			<div class="entry-breadcrumb clearfix" role="toolbar"><span class="glyphicon glyphicon-home" style="margin-right:8px"></span><?php wpmomo_breadcrumb_html(get_the_ID(),'&nbsp› &nbsp'); ?></div>

				<div class="panel-body">

					<div class="entry-header page-header">

						<h1 class="entry-title" itemprop="name"><?php echo apply_filters( 'dmeng_the_title', esc_html(get_the_title()) );?><?php if( is_preview() || current_user_can('edit_post', get_the_ID()) ) echo ' <small><a href="'.get_edit_post_link().'" data-no-instant>'.__('Edit This').'</a></small>'; ?></h1>

						<?php dmeng_post_meta();?>

					</div>			
					<?php global $post; 
						if ($post->post_excerpt) {
						echo '<div class="excerpt">';
							$excerpt= $post->post_excerpt;
 							echo $excerpt;
						echo '</div>';
					}
					?>
					<div class="entry-content"  itemprop="articleBody" data-no-instant>
						<?php the_content();?>
						<?php dmeng_post_page_nav(); ?>

					</div>

				</div>		
				<div style="border-top:1px solid #ddd;padding:20px 0;margin:20px 0;">
				<?php dmeng_post_footer();?>
				</div>
					<div class="clearfix"></div>
			</div>

			<div class="index-tit">

			<div class="tit" style="font-size:14px;padding-bottom:3px">猜您喜欢</div>
 

			</div>
	
			<ul id="tags_related">
			<?php
			
			global $post;
			$post_tags = wp_get_post_tags($post->ID);
			if ($post_tags) {
			foreach ($post_tags as $tag) {
				// 获取标签列表
				$tag_list[] .= $tag->term_id;
			}

			// 随机获取标签列表中的一个标签
			$post_tag = $tag_list[ mt_rand(0, count($tag_list) - 1) ];

			// 该方法使用 query_posts() 函数来调用相关文章，以下是参数列表
			$args = array(
				'tag__in' => array($post_tag),
				'category__not_in' => array(NULL),  // 不包括的分类ID
				'post__not_in' => array($post->ID),
				'showposts' => 6,                           // 显示相关文章数量
				'caller_get_posts' => 1
			);
			query_posts($args);

			if (have_posts()) {
				while (have_posts()) {
				the_post(); update_post_caches($posts); 
				
			$size = array(120 ,120);
				
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id() , $size);

			?>
			
			
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			
			<li>
			
			<img src="<? echo $image_url[0] ?>" width="<?php echo $image_url[1]; ?>" height="<?php echo $image_url[2]; ?> alt="<? echo get_the_title() ?>">
			
	
			
			<div style="color:#000;font-size:12px;line-height:18px;"><?php the_title(); ?></div>
			
			</li>
			
			</a>
			
			<?php
    }
  }
  else {
    echo '<div style="margin-bottom:40px">暂无相关文章</div>';
  }
  wp_reset_query();
}
else {
  echo '<div style="margin-bottom:40px">暂无相关文章</div>';
}
?>
</ul>

			<div class="<?php echo apply_filters('dmeng_comment_panel_class','panel panel-default');?>" id="comments" data-no-instant><?php comments_template( '', true ); ?></div>

			<?php
			$prev_post = get_previous_post(true);
			if (!empty( $prev_post )) {  ?>		
			<span id="nav_prev"><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="上一篇：<?php echo $prev_post->post_title; ?>">‹</a></span>		
			<?php } 		
			$next_post = get_next_post(true);
			if ( is_a( $next_post , 'WP_Post' ) ) { ?>
			<span id="nav_next"><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="下一篇：<?php echo get_the_title( $next_post->ID ); ?>">›</a></span>
			<?php } ?>
			
		 </article><!-- #content -->

		 

