<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */

//~ 积分换礼模板
global $wp_query;

$t = ( get_query_var( 't' ) ) ? intval(get_query_var( 't' )) : 0;
$max = ( get_query_var( 'max' ) ) ? intval(get_query_var( 'max' )) : 0;
$min = ( get_query_var( 'min' ) ) ? intval(get_query_var( 'min' )) : 0;

$gift_query_arg = array();
if($t) $gift_query_arg['t'] = $t;
if($max) $gift_query_arg['max'] = $max;
if($min) $gift_query_arg['min'] = $min;

$gift_archive_link = add_query_arg( $gift_query_arg, get_post_type_archive_link( 'gift' ) );

$filter_output = '';						
$terms = get_terms('gift_tag');
if ( !empty( $terms ) && !is_wp_error( $terms ) ){
	$filter_output .= '<dl class="clearfix">';
		$filter_output .= '<dt>'.__('按分类：', 'momo').'</dt>';
		$filter_output .= '<dd><ul>';
		$filter_tags[] = array(
			'title' => __('全部', 'momo'),
			'url' => remove_query_arg(array('t'), $gift_archive_link),
			'id' => 0
		);
		foreach ( $terms as $term ) {
			$filter_tags[] = array(
				'title' => $term->name,
				'url' => add_query_arg('t', $term->term_id, $gift_archive_link),
				'id' => $term->term_id
			);
			$terms_id[] = $term->term_id;
		}
		foreach( $filter_tags as $filter_tag ){
			$filter_id = in_array($filter_tag['id'], $terms_id) ? $filter_tag['id'] : 0;
			$filter_output .= sprintf('<li><a href="%s"%s>%s</a></li>', $filter_tag['url'], ($filter_id==$t ? ' class="active"' : ''), $filter_tag['title'] );
		}
		$filter_output .= '</ul></dd>';
	$filter_output .= '</dl>';
}

$dmeng_gift_filter = trim(get_option('dmeng_gift_filter', '0-100,100-1000,1000-10000,10000-0'),',');
$filter_credit_array = explode(',', $dmeng_gift_filter);
if($filter_credit_array){
	$filter_output .= '<dl class="clearfix">';
		$filter_output .= '<dt>'.__('按分类：', 'momo').'</dt>';
		$filter_output .= '<dd><ul>';
		$filter_output .= sprintf('<li><a href="%s"%s>%s</a></li>', remove_query_arg(array('min', 'max'), $gift_archive_link), ($min==0 && $max==0 ? ' class="active"' : ''), __('全部', 'momo') );
	foreach( $filter_credit_array as $filter_credit ){
		$filter_credit = explode('-', $filter_credit);
		$filter_credit_min = isset($filter_credit[0]) ? intval($filter_credit[0]) : 0;
		$filter_credit_max = isset($filter_credit[1]) ? intval($filter_credit[1]) : 0;
		
		$filter_credit_arg = array();
		$filter_credit_arg['min'] = $filter_credit_min;
		$filter_credit_arg['max'] = $filter_credit_max;
		
		$filter_credit_title = '';
		if($filter_credit_min && !$filter_credit_max) $filter_credit_title = $filter_credit_min.__('以上', 'momo');
		if(!$filter_credit_min && $filter_credit_max) $filter_credit_title = $filter_credit_max.__('以下', 'momo');
		if($filter_credit_min && $filter_credit_max) $filter_credit_title = $filter_credit_min .'-'. $filter_credit_max;
		
		$filter_output .= sprintf('<li><a href="%s"%s>%s</a></li>', add_query_arg($filter_credit_arg, $gift_archive_link ), ($filter_credit_min==$min && $filter_credit_max==$max ? ' class="active"' : ''), $filter_credit_title );
	}
		$filter_output .= '</ul></dd>';
	$filter_output .= '</dl>';
}

$filter_output .= '<div class="tips">';
$filter_output .= sprintf( __('当前条件共找到 %s 件礼品', 'momo'), $wp_query->found_posts);
$filter_output .= '</div>';

get_header(); 
?>
<?php get_header('masthead'); ?>
<div id="main" class="container">
	<div class="row">
		<div id="content" class="col-lg-8 col-md-8 archive" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
			<h1 class="hide"><?php post_type_archive_title();?></h1>
			<div class="panel panel-default">
				<div class="panel-body gift_filter">
					<?php echo $filter_output;?>
			<div class="row clearfix">
			<?php 

				while ( have_posts() ) : the_post();

					$post_link = $post->post_status=='publish' ? get_permalink() : 'javascript:;';
					
					$output = '<article class="col-lg-4 col-md-4 col-sm-4 archive-gift clearfix">';

					$thumbnail = dmeng_get_the_thumbnail();
					$output .= '<div class="entry-thumbnail gift-thumbnail"><a href="'.$post_link.'" title="'.get_the_title().'"><img src="'.wpmomo_script_uri('grey_png').'" data-original="'.$thumbnail.'" alt="'.get_the_title().'">'.( $post->post_status=='future' ? '<div class="future"><time>'.get_the_date(' Y-m-d H:i:s ').__('开始', 'momo').'</time></div>' : '' ).'</a></div>';

					$output .= '<div class="entry-meta">';
						$output .= sprintf('<a href="%s" class="link">%s</a>', $post_link, get_the_title() );
						$credit = intval(get_post_meta( get_the_ID(), 'dmeng_gift_credit', true ));
						$output .= sprintf('<span class="credit">%s</span>', ( $credit ? $credit.' '.__('积分', 'momo') : '<em>'.__('免费领取', 'momo').'</em>') . ( $post->post_status=='future' ? sprintf('<span class="future"> %s </span>', __('[兑换还没开始]', 'momo') ) : '') );
					$output .= '</div>';
					$output .= '</article>';
					
					echo $output;

				endwhile; // end of the loop. 

			?>
			</div>
				</div>
			</div>
			<?php
			
			//~ 分页导航
			dmeng_paginate();
			
			//~ 移除改变查询的钩子 ( inc/gift.php )，以防影响到侧边栏的查询
			remove_action( 'pre_get_posts', 'dmeng_gift_archive_page' );
			remove_filter( 'posts_where' , 'dmeng_gift_archive_page_posts_where' );
			remove_filter('posts_join', 'dmeng_gift_archive_page_posts_join');
			remove_filter( 'posts_groupby', 'dmeng_gift_archive_page_posts_groupby' );
			?>
		 </div><!-- #content -->
		<?php get_sidebar();?>
	</div>
 </div><!-- #main -->
<?php get_footer('colophon'); ?>
<?php get_footer(); ?>
