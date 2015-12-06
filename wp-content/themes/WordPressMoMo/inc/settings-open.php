<?php
/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦
 */
/*
 * 主题设置页面
 * 
 */
function dmeng_options_open_page(){
  if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='update' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :
	update_option( 'dmeng_open_weibo',  intval($_POST['open_weibo']) );
	update_option( 'dmeng_open_weibo_key',  sanitize_text_field($_POST['open_weibo_key']) );
	update_option( 'dmeng_open_weibo_secret',  sanitize_text_field($_POST['open_weibo_secret']) );
	update_option( 'dmeng_open_role',  sanitize_text_field($_POST['open_role']) );
	update_option( 'dmeng_open_remember_the_user',  intval($_POST['open_remember_the_user']) );
   dmeng_settings_error('updated');
  endif;
	$roles = array();
	$editable_roles = array_reverse( get_editable_roles() );
	foreach ( $editable_roles as $role => $details ) {
		$name = translate_user_role($details['name'] );
		$role = esc_attr($role);
		$roles[$role] = $name;
	}
	?>

<div class="wrap1">

	<h2><?php _e('WordPress MoMo','momo');?></h2>

	<form method="post">

		<input type="hidden" name="action" value="update">

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">

		<?php dmeng_admin_tabs('open');?>

		<p><?php _e('启用社会化登录需同时设置相关开放平台参数，否则无效。','momo');?></p>

		<?php
		$option = new DmengOptionsOutput();
		$option->table( array(
			array(
				'type' => 'select',
				'th' => __('启用微博登录','momo'),
				'key' => 'open_weibo',
				'value' => array(
					'default' => array(intval(get_option('dmeng_open_weibo',0))),
					'option' => array(
						1 => __( '启用', 'momo' ),
						0 => __( '关闭', 'momo' )
					)
				)
			),
			array(
				'type' => 'input',
				'th' => __('WEIBO KEY','momo'),
				'key' => 'open_weibo_key',
				'value' => get_option('dmeng_open_weibo_key')
			),

			array(
				'type' => 'input',
				'th' => __('WEIBO SECRET','momo'),
				'key' => 'open_weibo_secret',
				'value' => get_option('dmeng_open_weibo_secret')
			),
			array(
				'type' => 'select',
				'th' => __('默认角色','momo'),
				'before' => '<p>'.__('新登录用户的角色，默认是投稿者','momo').'</p>',
				'key' => 'open_role',
				'value' => array(
					'default' => array(get_option('dmeng_open_role', 'contributor')),
					'option' => $roles
				)
			),
			array(
				'type' => 'select',
				'th' => __('记住登录状态','momo'),
				'before' => '<p>'.__('使用QQ或微博登录的是否记住登录状态，不记住的话当关闭浏览器窗口后需要重新登录','momo').'</p>',
				'key' => 'open_remember_the_user',
				'value' => array(
					'default' => array(intval(get_option('dmeng_open_remember_the_user',1))),
					'option' => array(
						1 => __( '记住', 'momo' ),
						0 => __( '不记住', 'momo' )
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

