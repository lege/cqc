<?php/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦 */
get_header(); ?>
<?php get_header('masthead'); ?>
<div id="main" class="container">
	<div class="row">
		<div id="content" class="col-lg-8 col-md-8 archive" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<div class="<?php echo apply_filters('dmeng_archive_panel_class', 'panel panel-archive');?>" style="border:none;box-shadow:none">
				<div class="panel-body">
				<h1 class="h3 page-header panel-archive-title"><?php
						$separator = ' › ';
						if ( is_category() ){
							printf( __( '分类 : %s', 'momo' ), wpmomo_get_category_parents( get_queried_object_id(), $separator) );
						}elseif ( is_tag() ){						
							printf( __( '标签 : %s', 'momo' ), wpmomo_breadcrumb_output( get_tag_link(get_queried_object_id()), single_tag_title( '', false )).$separator );
						}elseif ( is_date() ){						
							$day = get_the_date('d');
							$month = get_the_date('m');
							$year = get_the_date('Y');
							$output[] =  wpmomo_breadcrumb_output( get_year_link($year), $year);
							if ( !is_year() ) $output[] =  wpmomo_breadcrumb_output( get_month_link($year, $month), $month);
							if ( !is_year() && !is_month() ) $output[] =  wpmomo_breadcrumb_output( get_day_link($year, $month, $day), $day);
							printf( __( '日期 : %s', 'momo' ), join( $separator, $output ).$separator );
						}else{
							_e( '归档', 'momo' );
						}
						global $wp_query;						
						$tracker = dmeng_tracker_param();
					?>
					<small> <span class="glyphicon glyphicon-list-alt"></span> <?php printf( '%s个相关结果', '<span itemprop="interactionCount">'.$wp_query->found_posts.'</span>' );?> <span class="glyphicon glyphicon-signal"></span> <?php printf( __( '%s次浏览', 'momo' ) , '<span data-num-views="true">'.get_dmeng_traffic($tracker['type'],$tracker['pid']).'</span>');?></small>
				</h1>
				<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description" itemprop="description">%s</div>', $term_description );						
					endif;
				?>
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