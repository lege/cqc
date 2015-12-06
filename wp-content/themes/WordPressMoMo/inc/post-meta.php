<?php



/*

 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言

 */



/*

 * 文章和页面相关信息面板 

 * 

 */



/**

 *  添加面板到文章（页面）编辑页

 */

function dmeng_add_meta_box() {



	$screens = array( 'post', 'page' );



	foreach ( $screens as $screen ) {



		add_meta_box(

			'dmeng_sectionid',

			__( '版权声明', 'momo' ),

			'dmeng_meta_box_callback',

			$screen

		);

	}

}

//add_action( 'add_meta_boxes', 'dmeng_add_meta_box' );



/**

 * 输出面板

 * 

 * @param WP_Post $post 当前文章（页面）对象

 */

function dmeng_meta_box_callback( $post ) {



	// 添加安全字段验证

	wp_nonce_field( 'dmeng_meta_box', 'dmeng_meta_box_nonce' );



	/*

	 * 获取文章相关信息

	 * 

	 */

	 

$cs = get_post_meta( $post->ID, 'dmeng_copyright_status', true );



$cc = get_post_meta( $post->ID, 'dmeng_copyright_content', true );



$copyright_status = is_numeric($cs) ? (int)$cs : (int)get_option('dmeng_copyright_status_default',1);



$copyright_content = $cc ? $cc : get_option('dmeng_copyright_content_default',sprintf(__('原文链接：%s，转发请注明来源！','momo'),'<a href="{link}" rel="author">{title}</a>'));



?>



<p>

	<select name="dmeng_copyright_status">

		<option value="1" <?php if( $copyright_status===1) echo 'selected="selected"';?>><?php _e( '显示', 'momo' );?></option>

		<option value="9" <?php if( $copyright_status!==1) echo 'selected="selected"';?>><?php _e( '不显示', 'momo' );?></option>

	</select>

</p>

<p><?php _e( '版权声明内容，文章链接用{link}表示，文章标题用{title}表示，站点地址用{url}表示，站点名称用{name}表示。', 'momo' );?></p>

<textarea name="dmeng_copyright_content" rows="1" cols="50" class="large-text code"><?php echo stripcslashes(htmlspecialchars_decode($copyright_content));?></textarea>



<?php

}



/**

 * 保存文章时页，保存自定义内容

 *

 * @param int $post_id 这是即将保存的文章ID

 */

function dmeng_save_meta_box_data( $post_id ) {



	/*

	 * 先执行安全检查

	 * 

	 */



	// 检查安全字段验证

	if ( ! isset( $_POST['dmeng_meta_box_nonce'] ) ) {

		return;

	}



	// 检查安全字段的值

	if ( ! wp_verify_nonce( $_POST['dmeng_meta_box_nonce'], 'dmeng_meta_box' ) ) {

		return;

	}



	// 检查是否自动保存，自动保存则跳出

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return;

	}



	// 检查用户权限

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {



		if ( ! current_user_can( 'edit_page', $post_id ) ) {

			return;

		}



	} else {



		if ( ! current_user_can( 'edit_post', $post_id ) ) {

			return;

		}

	}



	/* 好了，现在可以确认安全了 */

	

	// 检查和更新字段

	if ( isset( $_POST['dmeng_copyright_status'] ) ) update_post_meta( $post_id, 'dmeng_copyright_status', (int)$_POST['dmeng_copyright_status'] );

	

	if ( isset( $_POST['dmeng_copyright_content'] ) ) update_post_meta( $post_id, 'dmeng_copyright_content', htmlspecialchars($_POST['dmeng_copyright_content']) );

	

}

add_action( 'save_post', 'dmeng_save_meta_box_data' );

