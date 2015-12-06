<?php
/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言
 */
/*
 * 主题设置页面
 * 
 */

function dmeng_options_writing_page(){
	if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='update' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :	$int_update = array('copyright_status_default', 'post_index', 'post_index_page', 'post_min_strlen', 'post_max_strlen');
	foreach( $int_update as $int_item ){
		update_option( 'dmeng_'.$int_item, intval($_POST[$int_item]) );
	}
	$dmeng_can_post_cat = empty($_POST['can_post_cat']) ? array() : $_POST['can_post_cat'];
	update_option( 'dmeng_can_post_cat', json_encode($dmeng_can_post_cat) );
    dmeng_settings_error('updated');
	endif;
	$post_index = (int)get_option('dmeng_post_index',0);		$post_index_page = (int)get_option('dmeng_post_index_page',1);
	$can_post_cat = json_decode(get_option('dmeng_can_post_cat','[]'));
	$categories = get_categories( array('hide_empty' => 0) );
	foreach ( $categories as $category ) {

		$categories_array[$category->term_id] = $category->name;

	}



	$option = new DmengOptionsOutput();

	

	?>

<div class="wrap1">
	<h2><?php _e('WordPress MoMo','momo');?></h2>
	<form method="post">
		<input type="hidden" name="action" value="update">
		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
		<?php 
		dmeng_admin_tabs('writing');
		$option->table( array(
			array(
				'type' => 'select',
				'th' => __('锚点导航开关','momo'),
				'before' => '<p>'.__('选择是时将把文章页或页面内容中的H标题生成锚点导航目录<br><br>文章页面(Single页面)','momo').'</p>',
				'key' => 'post_index',
				'value' => array(
					'default' => array($post_index),
					'option' => array(
						1 => __( '显示', 'momo' ),
						0 => __( '不显示', 'momo' )
					)
				)
			),						array(				'type' => 'select',				'before' => '<p>'.__('页面(Page页面)','momo').'</p>',				'key' => 'post_index_page',				'value' => array(					'default' => array($post_index_page),					'option' => array(						1 => __( '显示', 'momo' ),						0 => __( '不显示', 'momo' )					)				)			)						
		) );

		?>

		<h3 class="title"><?php _e('投稿','momo');?></h3>

		<?php

		

		$option->table( array(

			array(

				'type' => 'checkbox',

				'th' => __('允许投稿的分类','momo'),

				'before' => '<p>'.__('不选择任何分类则不开放投稿','momo').'</p>',

				'key' => 'can_post_cat',

				'value' => array(

					'default' => $can_post_cat,

					'option' => $categories_array

				)

			),

			array(

				'type' => 'input',

				'th' => __('投稿的最少字数','momo'),

				'before' => '<p>'.__('限制最少字数，一篇文章少于这个字数不允许投稿。一条微博是140，所以默认是140字。','momo').'</p>',

				'key' => 'post_min_strlen',

				'value' => get_option('dmeng_post_min_strlen', 140)

			),

			array(

				'type' => 'input',

				'th' => __('投稿的最多字数','momo'),

				'before' => '<p>'.__('限制最多字数，一篇文章超过这个字数不允许投稿。刊物文章一般是2200-12000，所以默认12000字。','momo').'</p>',

				'key' => 'post_max_strlen',

				'value' => get_option('dmeng_post_max_strlen', 12000)

			),

		) );

		

		?>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '保存更改', 'momo' );?>"></p>

	</form>

</div>

	<?php

}

