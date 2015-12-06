<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦 */

/*
 * SEO @author 
 * at 2014.11.20 搜索页面参考了百度站长学院的《防止网站内部搜索被他人恶意利用》：http://zhanzhang.baidu.com/wiki/336
 */

/*
 * 通过 wp_title 钩子重写站点标题 @author 多梦 at 2014.06.19 
 * 
 */
function dmeng_wp_title( $title, $sep ) {

	if ( is_feed() ) return $title;
	
	global $wp_query, $paged, $page;

	if( is_single() ){
		$cat = array();
		foreach( (get_the_category() ) as $category ) {
			$cat[] = $category->cat_name; 
		}
		if($cat) $title .= join('|',$cat)." $sep " ;
	}

	switch(true){

		case  is_attachment() : 
			$title .= get_post_mime_type()." $sep " ;
		break;
		
		case is_category() :
			$title .= __('分类目录','momo')." $sep " ;
		break;
		
		case is_tag() :
			$title .= __('标签','momo')." $sep " ;
		break;

		case is_author() :
			$title .= __('作者','momo')." $sep " ;
		break;
		
		case is_archive() && !is_post_type_archive('gift') : 
			$title .= __('归档','momo')." $sep " ;
		break;
		
		case is_search() : 
			$title = __('搜索','momo')." $sep " ;
		break;
		
		case is_singular('gift') : 
			$title .= __('积分换礼','momo')." $sep " ;
		break;
	}

	// 添加站点标题
	$title .= get_bloginfo( 'name', 'display' );

	// 首页显示站点标题和副标题
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// 添加分页页码
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( '第 %s 页', 'momo' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'dmeng_wp_title', 10, 2 );

//~ 关键词和描述
function dmeng_keywords_and_description(){
	
	$keywords = array();
	$description = '';
	
	if( is_home() || is_front_page() ){
		$home_seo = json_decode(get_option('dmeng_home_seo','{"keywords":"","description":""}'));
		$keywords[] = $home_seo->keywords;
		$description = $home_seo->description;
	}
	
	if( is_single() || is_page() ){

		if ( has_tag() ) {
			foreach( (get_the_tags()) as $tag ) {
				 $keywords[] = $tag->name; 
			}
		}
		
		foreach( (get_the_category() ) as $category ) { 
			$keywords[] = $category->cat_name; 
		}
		
		$description = get_the_excerpt();
		
	}
	
	if( is_category() || is_tag() ){
		
		$keywords[] = single_term_title("", false);
		$description = strip_tags(term_description());
		
	}
	
	if( is_search() ){
		$description = __('搜索','momo');
		$keywords[] = $description;
	}
	
	
	echo '<meta name="keywords" content="'.esc_attr(wp_strip_all_tags(implode(",", $keywords))).'" /><meta name="description" content="'.esc_attr(wp_strip_all_tags($description)).'" />';
	
}
add_action('wp_head', 'dmeng_keywords_and_description');

//~ 页面链接后添加反斜杠
function dmeng_nice_trailingslashit($string, $type_of_url) {
	if ($type_of_url != 'single')
		$string = trailingslashit($string);
	return $string;
}
add_filter('user_trailingslashit', 'dmeng_nice_trailingslashit', 10, 2);
