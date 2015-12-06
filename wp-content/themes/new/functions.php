<?php

$dname = 'One';

add_action( 'after_setup_theme', 'deel_setup' );
include('admin/one.php');
include('widgets/index.php');
function deel_setup(){
//移除头部多余信息
remove_action('wp_head','wp_generator');//禁止在head泄露wordpress版本号
remove_action('wp_head','rsd_link');//移除head中的rel="EditURI"
remove_action('wp_head','wlwmanifest_link');//移除head中的rel="wlwmanifest"
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel=pre
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );//rel=shortlink 
remove_action('wp_head', 'rel_canonical' );

	//隐藏admin Bar
	function hide_admin_bar($flag) {
		return false;
	}
	add_filter('show_admin_bar','hide_admin_bar');

	//关键字
	add_action('wp_head','deel_keywords');   

	//页面描述 
	add_action('wp_head','deel_description');   

	//阻止站内PingBack
	if( dopt('d_pingback_b') ){
		add_action('pre_ping','deel_noself_ping');   
	}

	//Gzip压缩 
	add_action('init','deel_gzip');       

	//评论回复邮件通知
	add_action('comment_post','comment_mail_notify'); 

	//自动勾选评论回复邮件通知，不勾选则注释掉 
	// add_action('comment_form','deel_add_checkbox');

	//评论表情改造，如需更换表情，img/smilies/下替换
	add_filter('smilies_src','deel_smilies_src',1,10); 

	//文章末尾增加版权
	add_filter('the_content','deel_copyright');    

	//移除自动保存和修订版本
	if( dopt('d_autosave_b') ){
		add_action('wp_print_scripts','deel_disable_autosave' );
		remove_action('pre_post_update','wp_save_post_revision' );
	}

	//去除自带js
	wp_deregister_script( 'l10n' ); 

	//修改默认发信地址
	add_filter('wp_mail_from', 'deel_res_from_email');
	add_filter('wp_mail_from_name', 'deel_res_from_name');

	//缩略图设置
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(220, 150, true); 

	add_editor_style('editor-style.css');

	//头像缓存  
	if( dopt('d_avatar_b') ){
		add_filter('get_avatar','deel_avatar');  
	}

	//定义菜单
	if (function_exists('register_nav_menus')){
		register_nav_menus( array(
			'nav' => __('网站导航'),
			'pagemenu' => __('友情链接')
		));
	}

}


if ( ! function_exists( 'deel_paging' ) ) :
function deel_paging() {
	$p = 4;
	if ( is_singular() ) return;
	global $wp_query, $paged;
	$max_page = $wp_query->max_num_pages;
	if ( $max_page == 1 ) return; 
	echo '<div class="pagination"><ul>';
	if ( empty( $paged ) ) $paged = 1;
	// echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
	echo '<li>'; previous_posts_link('上一页'); echo '</li>';

	if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
	if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
	for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
		if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
	}
	if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
	//if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
	echo '<li>'; next_posts_link('下一页'); echo '</li>';
	// echo '<li><span>共 '.$max_page.' 页</span></li>';
	echo '</ul></div>';
}
function p_link( $i, $title = '' ) {
	if ( $title == '' ) $title = "第 {$i} 页";
	echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
}
endif;

function deel_strimwidth($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}

function dopt($e){
		return stripslashes(get_option($e));
	}

if ( ! function_exists( 'deel_views' ) ) :
function deel_record_visitors(){
	if (is_singular()) 
	{
	  global $post;
	  $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'deel_record_visitors');  

function deel_views($after=''){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  echo $views, $after;
}
endif;

if ( ! function_exists( 'deel_thumbnail' ) ) :
function deel_thumbnail() {  
	global $post;  
	if ( has_post_thumbnail() ) {   
		$domsxe = simplexml_load_string(get_the_post_thumbnail());
		$thumbnailsrc = $domsxe->attributes()->src;  
		echo '<img src="'.$thumbnailsrc.'" alt="'.trim(strip_tags( $post->post_title )).'" />';
	} else {
		$content = $post->post_content;  
		preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
		$n = count($strResult[1]);  
		if($n > 0){
			echo '<img src="'.$strResult[1][0].'" alt="'.trim(strip_tags( $post->post_title )).'" />';  
		}else {
			echo '<img src="'.get_bloginfo('template_url').'/img/thumbnail.jpg" alt="'.trim(strip_tags( $post->post_title )).'" />';  
		}  
	}  
}
endif;


/*function custom_login() {   
	echo '<link rel="stylesheet" href="' . get_bloginfo('template_directory') . '/misc/login.css">'; 
}
add_action('login_head', 'custom_login');   */


// 取消原有jQuery
if ( !is_admin() ) { 
	if ( $localhost == 0 ) { 
		function my_init_method() {
			wp_deregister_script( 'jquery' );
		}    
		add_action('init', 'my_init_method'); 
	}
}

$dHasShare = false;
function deel_share(){
  echo '<div class="share"><div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"><span class="share-tit">分享此文到：</span><a class="bds_tsina">新浪微博</a>
<a class="bds_qzone">QQ空间</a>
<a class="bds_tqq">腾讯微博</a>
<a class="bds_renren">人人网</a>
<a class="bds_douban">豆瓣网</a>
</div></div>';
  global $dHasShare;
  $dHasShare = true;
}

function deel_avatar_default(){ 
  return get_bloginfo('template_directory').'/img/default.png';
}

//评论头像缓存
function deel_avatar($avatar) {
  $tmp = strpos($avatar, 'http');
  $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
  $tmp = strpos($g, 'avatar/') + 7;
  $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
  $w = get_bloginfo('wpurl');
  $e = ABSPATH .'avatar/'. $f .'.png';
  $t = dopt('d_avatarDate')*24*60*60; 
  if ( !is_file($e) || (time() - filemtime($e)) > $t ) 
	copy(htmlspecialchars_decode($g), $e);
  else  
	$avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.png'));
  if ( filesize($e) < 500 ) 
	copy(get_bloginfo('template_directory').'/img/default.png', $e);
  return $avatar;
}




//关键字
function deel_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
	if ( get_the_tags( $post->ID ) ) {
	  foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
	}
	foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
	$keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () )    { $keywords = dopt('d_keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
	echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}

//网站描述
function deel_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
	if( !empty( $post->post_excerpt ) ) {
	  $text = $post->post_excerpt;
	} else {
	  $text = $post->post_content;
	}
	$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
	if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = dopt('d_description'); // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { $description = $blog_name . "'" . single_cat_title('', false) . "'";
  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' );
  echo "<meta name=\"description\" content=\"$description\">\n";
}


//最新发布加new 单位'小时'
function deel_post_new($timer='48'){
  $t=( strtotime( date("Y-m-d H:i:s") )-strtotime( $post->post_date ) )/3600; 
  if( $t < $timer ) echo "<i>new</i>";
}

//修改评论表情调用路径
function deel_smilies_src ($img_src, $img, $siteurl){
	return get_bloginfo('template_directory').'/img/smilies/'.$img;
}


//阻止站内文章Pingback 
function deel_noself_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
  if ( 0 === strpos( $link, $home ) )
  unset($links[$l]);
}


//移除自动保存
function deel_disable_autosave() {
  wp_deregister_script('autosave');
}

//Gzip压缩
function deel_gzip() {
  if ( strstr($_SERVER['REQUEST_URI'], '/js/tinymce') )
	return false;
  if ( ( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler' )
	return false;
  if (extension_loaded('zlib') && !ob_start('ob_gzhandler'))
	ob_start();
}


//修改默认发信地址
function deel_res_from_email($email) {
	$wp_from_email = get_option('admin_email');
	return $wp_from_email;
}
function deel_res_from_name($email){
	$wp_from_name = get_option('blogname');
	return $wp_from_name;
}
 

//自动勾选 
function deel_add_checkbox() {
  echo '<label for="comment_mail_notify" class="checkbox inline" style="padding-top:0"><input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>有人回复时邮件通知我</label>';
}

//文章（包括feed）末尾加版权说明
function deel_copyright($content) {
	if( !is_page() ){
		$content.= '<p>转载请注明：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> &raquo; <a href="'.get_permalink().'">'.get_the_title().'</a></p>';
	}
	return $content;
}

//时间显示方式‘xx以前’
function time_ago( $type = 'commennt', $day = 7 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (time() - $d('U') > 60*60*24*$day) return;
  echo ' (', human_time_diff($d('U'), strtotime(current_time('mysql', 0))), '前)';
}



//评论样式
function deel_comment_list($comment, $args, $depth) {
  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

  //头像
  echo '<div class="c-avatar">';
  echo get_avatar( $comment->comment_author_email, $size = '36' ,$default = get_bloginfo('template_directory') . '/img/default.png'); 
  echo '</div>';
  //内容
  echo '<div class="c-main" id="div-comment-'.get_comment_ID().'">';
	echo comment_text();
	if ($comment->comment_approved == '0'){
	  echo '<span class="c-approved">您的评论正在排队审核中，请稍后！</span><br />';
	}
	//信息
	echo '<div class="c-meta">';
		echo '<span class="c-author">'.get_comment_author_link().'</span>';
		echo get_comment_time('Y-m-d H:i '); echo time_ago(); 
		if ($comment->comment_approved !== '0'){ 
			echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
		echo edit_comment_link(__('(编辑)'),' - ','');
	  } 
	echo '</div>';
  echo '</div>';
}

//评论邮件自动通知  
function comment_mail_notify($comment_id) {  
  $admin_email = get_bloginfo ('admin_email');  
  $comment = get_comment($comment_id);  
  $comment_author_email = trim($comment->comment_author_email);  
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';  
  $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';  
  $spam_confirmed = $comment->comment_approved;  
  if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email) && ($comment_author_email == $admin_email)) {  
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));  
    $subject = '您在 [' . get_option("blogname") . '] 的评论有新的回复';  
    $message = '  
    <div style="font: 13px Microsoft Yahei;padding: 0px 20px 0px 20px;border: #ccc 1px solid;border-left-width: 4px; max-width: 600px;margin-left: auto;margin-right: auto;">  
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>  
      <p>您曾在 [' . get_option("blogname") . '] 的文章 《' . get_the_title($comment->comment_post_ID) . '》 上发表评论：<br />'  
       . nl2br(get_comment($parent_id)->comment_content) . '</p>  
      <p>' . trim($comment->comment_author) . ' 给您的回复如下:<br>'  
       . nl2br($comment->comment_content) . '</p>  
      <p style="color:#f00">您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看回复的完整內容</a></p>  
      <p style="color:#f00">欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>  
      <p style="color:#999">(此邮件由系统自动发出，请勿回复。)</p>  
    </div>';  
    $message = convert_smilies($message);  
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";  
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";  
    wp_mail( $to, $subject, $message, $headers );  
  }  
}  
add_action('comment_post', 'comment_mail_notify'); 

?>