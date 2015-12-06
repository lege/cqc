<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言 */
 
/*
 * 主题设置页面 - 阅读 
 * 
 */

function dmeng_options_reading_page(){

	$general_default = $GLOBALS['dmeng_general_default'];
  if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='update' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :
			update_option( 'momo_fancybox_on', intval($_POST['fancybox_on']) );		update_option( 'momo_fancybox_helper_on', intval($_POST['fancybox_helper_on']) );		update_option( 'dmeng_post_thumbnail', json_encode(array(
		'on' => intval($_POST['post_thumbnail_on']),
		'TimThumb' => $_POST['TimThumb'],
		'thumbnail_method' => $_POST['thumbnail_method'],
		'thumbnail_quality' => $_POST['thumbnail_quality']
	)) );	
	update_option( 'dmeng_google_code_prettify', intval($_POST['google_code_prettify']) );
	update_option( 'dmeng_general_setting', json_encode(wp_parse_args(
		wp_parse_args(
			array(
				'only_first_cat' => intval($_POST['only_first_cat'])
			),
			json_decode(get_option('dmeng_general_setting'), true)
		),
		$general_default
	)) );

    dmeng_settings_error('updated');
	  
  endif;	$fancybox_on = intval(get_option('momo_fancybox_on',1));		$fancybox_helper_on = intval(get_option('momo_fancybox_helper_on',1));	
  $post_thumbnail = json_decode(get_option('dmeng_post_thumbnail','{"on":"1","TimThumb":"0","thumbnail_method":"1","thumbnail_quality":"90"}'), true);
  $post_thumbnail_on = intval($post_thumbnail['on']);
  
  $TimThumb =  $post_thumbnail['TimThumb'];
  
  $thumbnail_method = $post_thumbnail['thumbnail_method'];
  
  $thumbnail_quality = $post_thumbnail['thumbnail_quality'];

	$google_code_prettify = intval(get_option('dmeng_google_code_prettify',0));

	$general_setting = json_decode(get_option('dmeng_general_setting'), true);
	$general_setting = wp_parse_args( $general_setting,  $general_default);
	
	$only_first_cat = $general_setting['only_first_cat'];

	$option = new DmengOptionsOutput();

	?>
<div class="wrap1">
	<h2><?php _e('WordPress MoMo','momo');?></h2>
	<form method="post">
		<input type="hidden" name="action" value="update">
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
		<?php 
		dmeng_admin_tabs('reading');
		$option->table( array(
			array(				'type' => 'select',				'th' => __('启用页面灯箱效果','momo'),				'before' => '<p>'.__('本主题使用fancybox将一篇文章中的图片串联显示(建议开启)','momo').'</p>',				'key' => 'fancybox_on',				'value' => array(					'default' => array($fancybox_on),					'option' => array(						1 => __( '开启', 'momo' ),						0 => __( '关闭', 'momo' )					)				)			),						array(				'type' => 'select',				'before' => '<p>'.__('启用button helper(上一篇、下一篇等按钮)(建议开启)','momo').'</p>',				'key' => 'fancybox_helper_on',				'value' => array(					'default' => array($fancybox_helper_on),					'option' => array(						1 => __( '开启', 'momo' ),						0 => __( '关闭', 'momo' )					)				)			),
		
			array(
				'type' => 'select',
				'th' => __('缩略图','momo'),
				'before' => '<p>'.__('缩略图来源','momo').'</p>',
				'key' => 'post_thumbnail_on',
				'value' => array(
					'default' => array($post_thumbnail_on),
					'option' => array(
						1 => __( '只显示特色图像', 'momo' ),
						2 => __( '没有特色图像时显示文章的第一张图片', 'momo' ),
						0 => __( '不显示', 'momo' )
					)
				)
			),
			
			array(

				'type' => 'select',

				'before' => '<p>'.__(' TimThumb 截图（建议开启） | MoMo主题使用 TimThumb 来生成缩略图，请确保当前主题的根目录可写（755权限）。如果你使用的是外链图库，请在当前主题根目录下的 timthumb-config.php 添加图库的域名。','momo').'</p>',

				'key' => 'TimThumb',

				'value' => array(

					'default' => array($TimThumb),

					'option' => array(

						0 => __( '开启*', 'momo' ),

						1 => __( '关闭', 'momo' )

					)

				)

			),
			
			
			array(

				'type' => 'select',

				'before' => '<p>'.__('截图模式 | 推荐：等比例缩小（适应最小边，裁剪大边，不变形）','momo').'</p>',

				'key' => 'thumbnail_method',

				'value' => array(

					'default' =>  array($thumbnail_method),

					'option' => array(

						0 => __( '直接压缩到固定高度和宽度（不裁剪，会变形）', 'momo' ),

						1 => __( ' 等比例缩小（适应最小边，裁剪大边，不变形）*', 'momo' ),

						2 => __( ' 等比例缩小（适应最大边，小边补白，不变形）', 'momo' )

					)

				)

			),
			
			array(

				'type' => 'input',

				'before' => '<p>'.__('缩略图质量 | 缩略图生成的质量（数值越大，质量越高，体积越大），最大100，默认90。','momo').'</p>',
				
				'after' => ' %',

				'key' => 'thumbnail_quality',

				'value' => $thumbnail_quality,
				
				'style' => 'width:50px'

			),
			array(
				'type' => 'select',
				'th' => __('着色代码','momo'),
				'before' => '<p>'.__('启用后将使用 Google Code Prettify 着色&lt;pre&gt;&lt;/pre&gt;标签内的代码。','momo').'</p>',
				'key' => 'google_code_prettify',
				'value' => array(
					'default' => array($google_code_prettify),
					'option' => array(
						1 => __( '启用', 'momo' ),
						0 => __( '禁用', 'momo' )
					)
				)
			),
			array(
				'type' => 'select',
				'th' => __('只显示一个分类','momo'),
				'before' => '<p>'.__('启用后归档页（分类页除外）META信息不显示分类，只在文章标题前显示第一个分类','momo').'</p>',
				'key' => 'only_first_cat',
				'value' => array(
					'default' => array($only_first_cat),
					'option' => array(
						1 => __( '启用', 'momo' ),
						0 => __( '不启用', 'momo' )
					)
				)
			),
		) );
		?>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '保存更改', 'momo' );?>"></p>
	</form>
</div>
	<?php
}
