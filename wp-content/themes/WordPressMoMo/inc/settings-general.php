<?php/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */
/*
 * 主题设置页面
 * 
 */
function dmeng_options_general_page(){
	$general_default = $GLOBALS['dmeng_general_default'];
	if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='update' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :
	update_option( 'zh_cn_l10n_icp_num', sanitize_text_field($_POST['zh_cn_l10n_icp_num']) );
	update_option( 'float_speed', sanitize_text_field($_POST['float_speed']) );
  			/****Favicon处理数据********/      if ( isset( $_POST['save_wpmomo_options'] ) ) { //save_wpmomo_options是先前输出的隐藏域           $new_option = $old_option = get_option('wpmomo_upload'); //获取老数据,新数据的值暂时和老数据一样           $new_option = $_POST['wpmomo_upload']; //获取提交的数据，新数据重新赋值                      if ( $old_option != $new_option ) { //如果新老数据不一样，就说明更改了               update_option( 'wpmomo_upload', $new_option ); //更新上数据           }       }  
	update_option( 'dmeng_general_setting', json_encode(wp_parse_args(
		wp_parse_args(
			array(
				'head_code' => htmlspecialchars($_POST['head_code']),
				'head_css' => htmlspecialchars($_POST['head_css']),
				'footer_code' => htmlspecialchars($_POST['footer_code']),				'theme_color' => intval($_POST['theme_color']),
				'float_button' => intval($_POST['float_button']),
				'qrcode' => intval($_POST['qrcode']),
				'instantclick' => ( $_POST['instantclick']=='mousedown' ? $_POST['instantclick'] : intval($_POST['instantclick']) ),
				'speedup' => ( empty($_POST['speedup']) ? array() : $_POST['speedup'] )
			),
			json_decode(get_option('dmeng_general_setting'), true)
		),
		$general_default
	)) );
	update_option( 'dmeng_black_list', sanitize_text_field($_POST['black_list']) );
	dmeng_settings_error('updated');
	endif;
	$general_setting = json_decode(get_option('dmeng_general_setting'), true);
	$general_setting = wp_parse_args( $general_setting,  $general_default);	
	$instantclick = $general_setting['instantclick'];	$theme_color = intval($general_setting['theme_color']);
	$float_button = intval($general_setting['float_button']);
	$qrcode = intval($general_setting['qrcode']);
	$head_code = $general_setting['head_code'];
	$head_css = $general_setting['head_css'];
	$footer_code = $general_setting['footer_code'];
	$speedup = $general_setting['speedup'];
	$head_code = stripslashes(htmlspecialchars_decode($head_code));
	$head_css = stripslashes(htmlspecialchars_decode($head_css));
	$footer_code = stripslashes(htmlspecialchars_decode($footer_code));
	?>
<div class="wrap1">
	<h2>WordPress MoMo</h2>
	<form method="post">
		<input type="hidden" name="action" value="update">
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
		<?php 
		dmeng_admin_tabs();		
		$option = new DmengOptionsOutput();     /******处理数据*****/  	echo '<div style="margin:20px 0">';	    echo '<div style="vertical-align: top;display:inline-block;padding: 20px 10px 20px 0px;width: 200px;line-height: 1.3;font-size:14px;font-weight: 600;">	<label>Favicon设置</label></div>';        echo '<div style="padding:10px;display:inline-block">	<p style="margin-bottom:3px;font-size:14px">设置您网站的Favicon图标</p>	<input type="text" size="60" value="'.get_option('wpmomo_upload').'" name="wpmomo_upload" class="wpmomo_url_input" id="wpmomo_upload_input"/>	<a id="wpmomo_upload" class="wpmomo_upload_button button" href="#">选择或上传</a></div>';              echo '<p><input type="hidden" value="1" name="save_wpmomo_options"/></p>';   		echo '</div>';				
		$option->table( array(					array(				'type' => 'select',				'th' => __('请设置您主题的颜色','momo'),				'before' => '<p>'.__('推荐是橘色，效果最好','momo').'</p>',				'key' => 'theme_color',				'value' => array(					'default' => array($theme_color),					'option' => array(						0 => __( '橘色（推荐）', 'momo' ),						1 => __( '蓝色', 'momo' ),						2 => __( '棕色', 'momo' ),						3 => __( '红色', 'momo' ),						4 => __( '青色', 'momo' ),					)				)			),
			array(
				'type' => 'input',
				'th' => __('ICP备案号','momo'),				'before' => '<p>'.__('备案号将出现在网站底部','momo').'</p>',
				'key' => 'zh_cn_l10n_icp_num',
				'value' => get_option('zh_cn_l10n_icp_num')
			),
			array(
				'type' => 'textarea',
				'th' => __('头部HEAD代码','momo'),
				'before' => '<p>'.__('如添加meta信息验证网站所有权。','momo').'</p>',
				'key' => 'head_code',
				'value' => $head_code
			),
			array(
				'type' => 'textarea',
				'th' => __('脚部统计代码','momo'),
				'before' => '<p>'.__('放置统计代码或安全网站认证小图标等。注意：如果是JS代码请添加一个data-no-instant属性，如&lt;script type="text/javascript" data-no-instant&gt; 。','momo').'</p>',
				'key' => 'footer_code',
				'value' => $footer_code
			),
			array(
				'type' => 'textarea',
				'th' => __('自定义CSS','momo'),
				'before' => '<p>'.__('以下内容会被放置在&lt;style&gt;标签之内，无需输入&lt;style type="text/css"&gt;和&lt;/style&gt;','momo').'</p>',
				'key' => 'head_css',
				'value' => $head_css
			),
			array(
				'type' => 'select',
				'th' => __('是否显示浮动按钮','momo'),
				'before' => '<p>'.__('选择是否显示到顶部、刷新、到底部等浮动按钮','momo').'</p>',
				'key' => 'float_button',
				'value' => array(
					'default' => array($float_button),
					'option' => array(
						1 => __( '显示', 'momo' ),
						0 => __( '不显示', 'momo' )
					)
				)
			),
			array(
				'type' => 'input',
				'th' => __('设置页面滚动速度','momo'),
				'before' => '<p>'.__('设置页面滚动到顶部、底部等位置所用的时间（以毫秒为单位，推荐800ms）','momo').'</p>',
				'key' => 'float_speed',
				'value' => get_option('float_speed','800')
			),
			array(
				'type' => 'select',
				'th' => __('是否显示二维码','momo'),
				'before' => '<p>'.__('选择是否在浮动按钮中显示二维码','momo').'</p>',
				'key' => 'qrcode',
				'value' => array(
					'default' => array($qrcode),
					'option' => array(
						1 => __( '显示', 'momo' ),
						0 => __( '不显示', 'momo' )
					)
				)
			),
			array(
				'type' => 'input',
				'th' => __('预加载','momo'),
				'before' => '<p>'.__('InstantClick 功能仅供测试，填写数字“0”表示关闭，推荐您填写一个毫秒值，如“400”','momo').'</p>',
				'key' => 'instantclick',
				'value' => $instantclick
			),
		) );

		?>
		<h3><?php _e( '登录安全', 'momo' );?></h3>
		<?php

		$option->table( array(
			array(
				'type' => 'input',
				'th' => __('黑名单','momo'),
				'key' => 'black_list',
				'after' => '<p>'.__('请使用 | 分隔开，而且 | 前后都不要留空格。请慎重！黑名单里的用户名都不能用来注册，也不能登录。<span style="color:#a94442">推荐把管理员用户名添加进来，然后使用邮箱登录，此举可以大量减少暴力破解可能会浪费的服务器资源。</span>','momo').'</p>',
				'value' => get_option( 'dmeng_black_list')
			),
		) );
						/******以下是添加的js****/      wp_enqueue_media(); //在设置页面需要加载媒体中心       ?>       <script>       jQuery(document).ready(function(){       var wpmomo_upload_frame;       var value_id;       jQuery('.wpmomo_upload_button').live('click',function(event){           value_id =jQuery( this ).attr('id');               event.preventDefault();           if( wpmomo_upload_frame ){               wpmomo_upload_frame.open();               return;           }           wpmomo_upload_frame = wp.media({               title: '插入图像',               button: {                   text: '选择',               },               multiple: false           });           wpmomo_upload_frame.on('select',function(){               attachment = wpmomo_upload_frame.state().get('selection').first().toJSON();               jQuery('input[name='+value_id+']').val(attachment.url);           });                      wpmomo_upload_frame.open();       });       });       </script>  		
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '保存更改', 'momo' );?>"></p>
	</form>
</div>
	<?php
} 
