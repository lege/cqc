<?php
/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言
 */


/*
 * 主题设置页面 - 高级工具 @author MoMo
 * 
 */



function dmeng_options_tool_page(){

	$themes = wp_get_themes(array( 'errors' => false , 'allowed' => null ));

	if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='clear' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :

	$nonce = explode("+", trim($_POST['nonce_title']));
	if( $nonce[0]==__('我确认操作','momo') && wp_verify_nonce( $nonce[1], 'check-captcha' ) ) {
	global $wpdb;



		//~ 删除主题自己建的表

		$table_message = $wpdb->prefix . 'dmeng_message';   
		$wpdb->query("DROP TABLE IF EXISTS ".$table_message);
		$table_meta = $wpdb->prefix . 'dmeng_meta';   
		$wpdb->query("DROP TABLE IF EXISTS ".$table_meta);
		
		$table_tracker = $wpdb->prefix . 'dmeng_tracker';   
		$wpdb->query("DROP TABLE IF EXISTS ".$table_tracker);



		//~ 清理在WordPress表格中的数据

		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'dmeng_%'" );

		$wpdb->query( "DELETE FROM $wpdb->posts WHERE post_type LIKE 'gift'" );

		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE 'dmeng_%'" );

		$wpdb->query( "DELETE FROM $wpdb->term_taxonomy WHERE taxonomy LIKE 'gift_tag'" );

		$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key LIKE 'dmeng_%'" );

		$wpdb->query( "DELETE FROM $wpdb->commentmeta WHERE meta_key LIKE 'dmeng_%'" );

		wp_cache_flush();


		//~ 切换到其他主题
		if( isset($_POST['theme']) ) {

			foreach(	$themes as $theme_name=>$theme_data ){

				if( $theme_data->stylesheet == $_POST['theme'] ){

					switch_theme( $theme_name );

					printf("<script>window.location.href='%s';</script>", admin_url('themes.php?activated=true'));

					exit;
				}
			}
		}

	}else{

		dmeng_settings_error('error',__('验证码有误，请重试。','momo'));
	}



  endif;

  

	if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='refresh' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) {

		

		dmeng_refresh_all();

		

		dmeng_settings_error('updated',__('缓存已清理','momo'));

	}

	

	if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='check-version' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) {

		

		if( dmeng_check_version_do_this_daily() ){

			dmeng_settings_error('updated', sprintf(__('版本检查成功，获取到的最新版本是：%s','momo'), get_option('dmeng_theme_upgrade')));

		}else{

			dmeng_settings_error('error', __('版本检查失败，请重试！','momo'));

		}

	}

	$tab = 'refresh';

	if( isset($_GET['tab'])){

		if(in_array($_GET['tab'], array('clear','about','refresh', 'version'))) $tab = $_GET['tab'];

	}
	$dmeng_tabs = array(
		'refresh' => __('清理缓存', 'momo'),

		'clear' => __('主题数据清理', 'momo'),

		'version' => __('版本升级', 'momo')

	);

	$tab_output = '<h2 class="nav-tab-wrapper">';

	foreach( $dmeng_tabs as $tab_key=>$tab_name ){

		$tab_output .= sprintf('<a href="%s" class="nav-tab%s">%s</a>', add_query_arg('tab', $tab_key), $tab_key==$tab ? ' nav-tab-active' : '', $tab_name);

	}

	$tab_output .= '</h2>';

	



	?>

<div class="wrap1">

	<h2><?php _e('WordPress MoMo','momo');?></h2>

	<form method="post">

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">

		<?php echo $tab_output;?>

<div style="border:1px solid #e5e5e5;padding:15px;background:#fff;margin:15px 0;">

		<?php if($tab=='clear'){ ?>

		<input type="hidden" name="action" value="clear">

		<p><?php _e('MoMo主题数据包括版权声明、幻灯片、浏览次数、投票数据、消息、积分、礼品等。这些数据属于MoMo主题私有。','momo');?></p>

		<p><?php _e('清理范围包括： 删除 dmeng_message、dmeng_meta、dmeng_tracker 三个表，删除 options、postmeta、usermeta、commentmeta 表以 dmeng_ 开头为 key 的数据和 gift 文章类型和 gift_tag  分类法。注：MoMo主题在 wordpress table 中存储的全部数据的 key 都是以 dmeng_ 开头的。','momo');?></p>

		<p style="color:#d98500;"><?php _e('选择清理数据后要切换到的主题。如果选择的是MoMo主题，则相当于清理现有数据，重新启用MoMo主题。','momo');?></p>

<?php



		$themes_output = '<select name="theme">';

		foreach(	$themes as $theme_name=>$theme_data ){

			$themes_output .= '<option value="'.$theme_data->stylesheet.'">'.$theme_data->stylesheet.'</option>';

		}

		$themes_output .= '</select>';

		

		echo $themes_output;

?>

		<p style="color:#0074a2;"><?php _e('如果你确定清理并停用MoMo主题，请按提示输入”我确认操作”+验证字符的组合（+号也要输入），然后点击清理并停用。','momo');?></p>

		<p><?php

		//~ 把一段中文这样分开是防止本地化之后无法验证文字

		_e('请输入：','momo');

		_e('我确认操作','momo');

		echo '+'.wp_create_nonce('check-captcha');?></p>

		<p><input name="nonce_title" type="text" id="nonce_title" value="" class="regluar-text ltr"> <span style="color:#dd3d36;"><?php _e('请先备份数据库，以防不测。','momo');?></span></p>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary confirm" value="<?php _e( '清理并停用', 'momo' );?>"></p>

		<p><?php _e('清理WordPress冗余数据（如修订版本、回收站中的文章/垃圾评论等），推荐使用 WP Clean Up  。','momo');?>

		

	</form>



<script type="text/javascript">

jQuery(document).ready(function($){

	$('#nonce_title').bind("paste", function(e) {

		alert('<?php _e('为了您的数据安全，请不要直接复制粘贴！','momo');?>');

		e.preventDefault();

	});

	jQuery('.confirm').live('click',function(event){

		var r = confirm( '<?php _e('确定要清理吗？你备份数据库了吗？本操作不可逆！','momo');?>' );

		if ( r == false ) return false;

    });

});

</script>

	<?php }

	



	

	if($tab=='refresh'){

	?>

	<p style="color:#0074a2;"><?php _e('如果站点启用了内存对象缓存，会使用对象缓存缓存数据，否则保存成一个字段到数据库中以减少查询。建议配置 Memcached 对象缓存！','momo');?></p>

	<p><?php _e('MoMo主题有以下几个自定义项目使用 Transients API 缓存数据。','momo');?></p>

	<ol>

		<li><?php _e('导航菜单','momo');?></li>

		<li><?php _e('首页分类列表','momo');?></li>

		<li><?php _e('小工具（最近登录用户、文章排行榜、积分排行榜、站点统计）','momo');?></li>

	</ol>

	<p><?php _e('一般情况下，导航菜单缓存在更新菜单时会更新，首页分类列表缓存在更新首页设置时更新，小工具缓存在更新该小工具时会更新（最近登录用户在有用户登录时也会更新缓存），除此之外，全站内容缓存会每隔一小时更新一次。所以，手动刷新缓存几乎是没有必要的，仅仅是备用。','momo');?></p>

	<input type="hidden" name="action" value="refresh">

	<p class="submit"><input type="submit" name="submit" id="submit" class="button" value="<?php _e( '点击清理缓存', 'momo' );?>"></p>

	<?php _e('清理范围包括对象缓存、 Transients、固定链接缓存等。谨慎操作！','momo');?>

	<?php

	}

	

	if($tab=='version'){

	?>

	

	<p><?php _e('下载MoMo主题最新版本请点击：','momo');?><a href="http://www.wpmomo.com/" target="_blank">MoMo网络 >></a></p>

	

	<p style="color:#0074a2;"><?php 



	printf(__('当前版本是：%s ', 'momo'), get_option('dmeng_version') );

	

	printf(__('上次检查版本是：%s ', 'momo'), get_option('dmeng_theme_upgrade') );

	

	$time = wp_next_scheduled( 'dmeng_check_version_daily_event' );

	if( $time ){

		printf(__('下次自动检查时间是：%s', 'momo'), date('Y-m-d H:i:s', $time));

	}

	?></p>



	<p><?php _e('如果你已经升级，但还是提示升级，你可以点击这里刷新版本数据。','momo');?></p>

	<input type="hidden" name="action" value="check-version">

	<p><input type="submit" name="submit" id="submit" class="button" value="<?php _e( '刷新版本数据', 'momo' );?>"></p>

	

	



	<?php

	}

	?>

</div>

</div>

	<?php

}

