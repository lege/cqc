<?php
/* * 亲，如果您喜欢本主题，请上http://www.wpmomo.com发表留言 */
$key = get_search_query();
//~ 搜索关键词为空时跳转到 0 的搜索结果
if($key==''){
	wp_redirect( add_query_arg( 's', 0 ), 301 ); exit;
}
global $wp_query;
get_header(); ?>
<?php get_header('masthead'); ?>
<div id="main" class="container">
	<div class="row">
		<div id="content" class="col-lg-8 col-md-8 archive search-archive" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/SearchResultsPage">
			<div class="<?php echo apply_filters('dmeng_archive_panel_class', 'panel panel-default panel-archive');?>">
				<div class="panel-body">
				<h1 class="h3 page-header panel-archive-title"><span itemprop="name"><?php echo $key; ?></span> <small> <span class="glyphicon glyphicon-list-alt"></span> <?php printf( '%s个相关结果', '<span itemprop="interactionCount">'.$wp_query->found_posts.'</span>' );?> <span class="glyphicon glyphicon-signal"></span> <?php printf( __( '%s次搜索', 'momo' ) , get_dmeng_traffic('search',$key) ); ?></small>
				</h1>
			<?php 
				while ( have_posts() ) : the_post();
					get_template_part('content','archive');
				endwhile; // end of the loop. 
				dmeng_paginate();
			?>
				</div>
			</div>
		 </div><!-- #content -->
		<?php get_sidebar();?>
	</div>
 </div><!-- #main -->
<?php get_footer('colophon'); ?>
<?php get_footer(); ?>