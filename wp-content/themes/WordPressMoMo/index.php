<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言 */

get_header(); ?>

<?php get_header('masthead'); ?>

<div id="main" class="container">

	<div class="row">

	<div id="content" class="col-lg-8 col-md-8 archive" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

<?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$home_setting = json_decode(get_option('dmeng_home_setting','{"page":"","cat_list":"2","cat_desc":"","post":"1","post_title":"","ignore_sticky_posts":"1","sticky_posts_title":"{title}","post_exclude":"[]"}'));$home_page_des = json_decode(get_option('home_page_des','{"home_page1_des":"","home_page2_des":"","home_page3_des":""}'));
$home_ignore_sticky_posts = intval($home_setting->ignore_sticky_posts);

//~ 只在第一页显示幻灯片和分类列表等。
if( $paged<2 ){

	//~ 首页幻灯片
	$slide_home = intval(get_option('dmeng_slide_home',0));
	if( $slide_home ) echo dmeng_slide_to_html($slide_home);


?>

<div class="row" >

   <? $home_page1 = $home_setting->page1;

$page_data = get_page( $home_page1 ); 

?>

    <div class="col-lg-4 col-md-4 col-sm-4" style="margin-bottom:20px;">
		<a href="<? echo get_page_link ($home_page1) ; ?> " style="text-decoration:none" >
		<div style="padding:10px 10px 10px 70px;border:1px solid #e1e1e1;"  class="hvr-icon-buzz-out theme-color-font">
		
		<div style="font-size:16px;font-family:microsoft yahei" ><? echo $page_data->post_title ?></div>
		<div style="font-size:12px;color:#999;"><? echo $home_page_des->home_page1_des ?></div>
		
		</div>
		</a>
	</div>
	
<?	$home_page2 = $home_setting->page2;

$page_data = get_page( $home_page2 ); ?>


	 <div class="col-lg-4 col-md-4 col-sm-4 " style="margin-bottom:20px;" >
	 
		<a href="<? echo get_page_link ($home_page2) ; ?> " style="text-decoration:none">
		<div style="padding:10px 10px 10px 70px;border:1px solid #e1e1e1;"  class="hvr-icon-wobble-horizontal theme-color-font">
		
		<div style="font-size:16px;font-family:microsoft yahei" ><? echo $page_data->post_title ?></div>
		<div style="font-size:12px;color:#999;"><? echo $home_page_des->home_page2_des ?></div>
		
		</div>
		</a>
		
	 </div>
	 
<?	 $home_page3 = $home_setting->page3;

$page_data = get_page( $home_page3 ); ?>


    <div class="col-lg-4 col-md-4 col-sm-4 " style="margin-bottom:20px;"">
		<a href="<? echo get_page_link ($home_page3) ; ?> " style="text-decoration:none"  >
		<div style="padding:10px 10px 10px 70px;border:1px solid #e1e1e1;" class="hvr-icon-wobble-vertical theme-color-font">
		<div style="font-size:16px;font-family:microsoft yahei" ><? echo $page_data->post_title ?></div>
		<div style="font-size:12px;color:#999;"><? echo $home_page_des->home_page3_des ?> </div>
		
		</div>
		</a>
	</div>
    

</div>

<?
}
//~ 文章列表
$home_post = intval($home_setting->post);
if($home_post){
	
	$home_post_exclude = (array)$home_setting->post_exclude;

	$query_args = array();
	
	$query_args['ignore_sticky_posts'] = $home_ignore_sticky_posts;

	$query_args['paged'] = $paged;
	
	if($home_post_exclude) $query_args['category__not_in'] = $home_post_exclude;
	if($home_post===1) $query_args['orderby'] = 'date';
	if($home_post===2) $query_args['orderby'] = 'modified';
	if($home_post===3) $query_args['orderby'] = 'comment_count';
	
	//~ 如果置顶文章单独显示在上面了，这下面的列表就排除置顶文章吧～
	if($home_ignore_sticky_posts===2) $query_args['post__not_in'] = get_option( 'sticky_posts' );
	$home_post_title = '';
	if( $paged>=2 ) $home_post_title .= sprintf( ' <small>' . __( '第 %s 页', 'momo' ) . '</small>', $paged );
	?>

	<div class="index-tit">
    <div class="tit"><?php echo $home_setting->post_title ?></div>
	</div>
	
	<?

	echo '<div class="panel panel-archive" role="main" style="border:none;box-shadow:none"><div class="panel-body">';
	if($home_post_title) echo '<h3 class="page-header panel-archive-title">'.$home_post_title.'</h3>';

		query_posts( $query_args );
			while ( have_posts() ) : the_post();
				get_template_part('content','archive');
			endwhile; // end of the loop.
			
			dmeng_paginate();
			
		

		wp_reset_query();
	
	echo '</div></div>';

}

?>
	 </div><!-- #content -->
	<?php get_sidebar();?>
	</div>
	
	
	<?php
	global $wp_query;
	$url = home_url('/');
	$paged = get_query_var('paged');
	$prepage = $paged + 1;
	$nextpage = $paged - 1;
	$preurl = add_query_arg( 'paged', $prepage , $url );
	$nexturl = add_query_arg( 'paged', $nextpage , $url );
	?>
	
	<?php if ($prepage <= $wp_query->max_num_pages){ ?>

	<span id="nav_prev"><a href="<?php echo $preurl ?>" title="<?php echo sprintf('第 %s 页',$prepage) ?>">‹</a></span>
			
	<?php } ?>
	
	<?php if ($nextpage > 0){  ?>		
	<span id="nav_next"><a href="<?php echo $nexturl ?>" title="<?php echo sprintf('第 %s 页',$nextpage); ?>">›</a></span>	 
	<?php } ?>
			
		
	
	
 </div><!-- #main -->

<?php get_footer('colophon'); ?>
<?php get_footer(); ?>
