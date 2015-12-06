<?php



/*

 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言

 */

 

/*

 * 主题设置页面 - 讨论 

 * 

 */



function dmeng_options_discussion_page(){

	

  if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='update' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :



	update_option( 'dmeng_sticky_comment_title', sanitize_text_field($_POST['sticky_comment_title']) );

	update_option( 'dmeng_sticky_comment_button_txt', sanitize_text_field($_POST['sticky_comment_button_txt']) );		update_option( 'dmeng_sticky_comment_button_txt_cancel', sanitize_text_field($_POST['sticky_comment_button_txt_cancel']) );

	update_option( 'dmeng_hide_comment_email', intval($_POST['hide_comment_email']) );



    dmeng_settings_error('updated');

	  

  endif;

  

	$title = get_option('dmeng_sticky_comment_title', __('置顶评论','momo'));

	$button_txt = get_option('dmeng_sticky_comment_button_txt',__('置顶','momo'));
	$button_txt_cancel = get_option('dmeng_sticky_comment_button_txt_cancel',__('取消置顶','momo'));
	$hide = intval(get_option('dmeng_hide_comment_email', 1));

	?>

<div class="wrap1">

	<h2><?php _e('WordPress MoMo','momo');?></h2>

	<form method="post">

		<input type="hidden" name="action" value="update">

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">

		<?php

		

		dmeng_admin_tabs('discussion');

		

		$option = new DmengOptionsOutput();

		$option->table( array(

			array(

				'type' => 'input',

				'th' => __('“置顶评论”标题文本','momo'),

				'key' => 'sticky_comment_title',

				'value' => $title

			),

			array(
				'type' => 'input',
				'th' => __('“置顶”按钮文本','momo'),
				'key' => 'sticky_comment_button_txt',
				'value' => $button_txt
			),						array(				'type' => 'input',				'th' => __('“取消置顶”按钮文本','momo'),				'key' => 'sticky_comment_button_txt_cancel',				'value' => $button_txt_cancel			),

			array(

				'type' => 'select',

				'th' => __('隐藏邮箱地址','momo'),

				'before' => '<p>'.__('自动隐藏评论中的邮箱地址，只有评论作者、文章作者或更高权限的用户可见','momo').'</p>',

				'key' => 'hide_comment_email',

				'value' => array(

					'default' => array(intval($hide)),

					'option' => array(

						1 => __( '隐藏', 'momo' ),

						0 => __( '不隐藏', 'momo' )

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

