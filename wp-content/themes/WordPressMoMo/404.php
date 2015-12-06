<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言 */
get_header(); ?>
<?php get_header('masthead'); ?>
<div id="main" class="container">
	<div class="row">
		<div id="content" class="col-lg-8 col-md-8" role="main">
			<article class="<?php echo apply_filters('dmeng_archive_panel_class', 'panel panel-default panel-archive');?>" role="main">
					<div class="panel-body">
						<h1 class="h3 page-header"><?php _e('未找到页面','momo');?> <small><?php _e('404 NO FOUND','momo');?></small></h1>
						<ul>
						<li>						<h4><?php _e('可能导致的原因','momo');?></h4>
							<ol>
							<li><?php _e('输入的链接有误','momo');?></li>
							<li><?php _e('请求的页面不存在','momo');?></li>
							</ol>
						</li>
						</ul>
						<h3 class="page-header"><?php _e('看看别的吧','momo');?> <small><?php _e('最近更新','momo');?></small></h3>
			<?php 
				query_posts( array( 'ignore_sticky_posts' => true, 'posts_per_page' => 5, 'orderby' => 'modified') );
				while ( have_posts() ) : the_post();
					get_template_part('content','archive');
				endwhile; // end of the loop. 
				wp_reset_query();
			?>
					</div>
			 </article>
		 </div><!-- #content -->
		 <?php get_sidebar();?>
	</div>
 </div><!-- #main -->
<?php get_footer('colophon'); ?>
<?php get_footer(); ?>