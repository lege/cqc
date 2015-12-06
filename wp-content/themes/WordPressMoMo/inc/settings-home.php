<?php
/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦
 */

/*
 * 首页设置页面
 * 
 */


function dmeng_options_home_page(){
  if( isset($_POST['action']) && sanitize_text_field($_POST['action'])=='update' && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :

	update_option( 'dmeng_home_seo', json_encode(array(
		'keywords' => sanitize_text_field($_POST['home_keywords']),
		'description' => sanitize_text_field($_POST['home_description'])
	)));			update_option( 'home_page_des', json_encode(array(		'home_page1_des' => sanitize_text_field($_POST['home_page1_des']),		'home_page2_des' => sanitize_text_field($_POST['home_page2_des']),		'home_page3_des' => sanitize_text_field($_POST['home_page3_des']),	)));
	$dmeng_home_page1 = empty($_POST['home_page1']) ? "" : $_POST['home_page1'];
	$dmeng_home_page2 = empty($_POST['home_page2']) ? "" : $_POST['home_page2'];
	$dmeng_home_page3 = empty($_POST['home_page3']) ? "" : $_POST['home_page3'];
	$dmeng_home_post_exclude = empty($_POST['home_post_exclude']) ? array() : $_POST['home_post_exclude'];

	update_option( 'dmeng_home_setting', json_encode(array(
		'page1' => $dmeng_home_page1,
		'page2' => $dmeng_home_page2,
		'page3' => $dmeng_home_page3,
		'post' => intval($_POST['home_post']),
		'post_title' => $_POST['home_post_title'],
		'ignore_sticky_posts' => intval($_POST['home_ignore_sticky_posts']),
		'post_exclude' => $dmeng_home_post_exclude
	)));



	dmeng_settings_error('updated');

	  

  endif;
	$home_seo = json_decode(get_option('dmeng_home_seo','{"keywords":"","description":""}'));		$home_page_des = json_decode(get_option('home_page_des','{"home_page1_des":"","home_page2_des":"","home_page3_des":""}'));
	$home_setting = json_decode(get_option('dmeng_home_setting','{"page1":"[]","page2":"[]","page3":"[]","cat_list":"2","cat_desc":"","post":"1","post_title":"","ignore_sticky_posts":"1","sticky_posts_title":"{title}","post_exclude":"[]"}'));
	$home_page1 = (array)$home_setting->page1;
	$home_page2 = (array)$home_setting->page2;
	$home_page3 = (array)$home_setting->page3;
	$home_post = intval($home_setting->post);
	$home_post_title = $home_setting->post_title;
	$home_ignore_sticky_posts = intval($home_setting->ignore_sticky_posts);
	$home_post_exclude = (array)$home_setting->post_exclude;

	$pages = get_pages( );

	foreach ( $pages as $page ) {
		$page_array[$page->ID] = $page->post_title;
	}

	$categories = get_categories( array('hide_empty' => 0) );
	foreach ( $categories as $category ) {
		$categories_array[$category->term_id] = $category->name;
	}
	?>

<div class="wrap1">
	<h2><?php _e('WordPress MoMo','momo');?></h2>
	<form method="post">
		<input type="hidden" name="action" value="update">

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">
		<?php

		dmeng_admin_tabs('home');
		$option = new DmengOptionsOutput();

		$option->table( array(

			array(
				'type' => 'input',
				'th' => __('首页关键词','momo'),
				'before' => '<p>'.__('网站首页的网页关键词','momo').'</p>',
				'key' => 'home_keywords',
				'value' => $home_seo->keywords
			),

			array(
				'type' => 'textarea',
				'th' => __('首页描述','momo'),
				'before' => '<p>'.__('网站首页的网页描述，推荐200字以内','momo').'</p>',
				'key' => 'home_description',
				'value' => $home_seo->description

			),

			array(
				'type' => 'select',
				'th' => __('幻灯片下方三个页面的设置','momo'),
				'before' => '<p>'.__('第一个页面','momo').'</p>',
				'key' => 'home_page1',				
				'value' => array(
					'default' => $home_page1,
					'option' => $page_array
				)
			),									array(				'type' => 'input',				'before' => '<p>'.__('描述','momo').'</p>',				'key' => 'home_page1_des',								'value' => $home_page_des->home_page1_des							),

			array(
				'type' => 'select',
				'before' => '<p>'.__('第二个页面','momo').'</p>',
				'key' => 'home_page2',
				'value' => array(
					'default' => $home_page2,
					'option' => $page_array
				)
			),									array(				'type' => 'input',				'before' => '<p>'.__('描述','momo').'</p>',				'key' => 'home_page2_des',								'value' => $home_page_des->home_page2_des							),
			array(
				'type' => 'select',
				'before' => '<p>'.__('第三个页面','momo').'</p>',
				'key' => 'home_page3',
				'value' => array(
					'default' => $home_page3,
					'option' => $page_array
				)
			),						array(				'type' => 'input',				'before' => '<p>'.__('描述','momo').'</p>',				'key' => 'home_page3_des',								'value' => $home_page_des->home_page3_des							),

			array(
				'type' => 'select',
				'th' => __('文章列表','momo'),
				'before' => '<p>'.__('首页文章列表','momo').'</p>',
				'key' => 'home_post',
				'value' => array(
					'default' => array($home_post),
					'option' => array(
						1 => __( '最新发表的', 'momo' ),
						2 => __( '最后更新的', 'momo' ),
						3 => __( '评论最多的', 'momo' ),
						0 => __( '不显示', 'momo' )
					)
				)
			),

			array(
				'type' => 'input',
				'th' => __('文章列表标题','momo'),
				'before' => '<p>'.__('如：最新文章。留空不显示','momo').'</p>',
				'key' => 'home_post_title',
				'value' => $home_post_title
			),

			array(
				'type' => 'select',
				'th' => __('排除文章','momo'),
				'before' => '<p>'.__('置顶显示置顶文章','momo').'</p>',
				'key' => 'home_ignore_sticky_posts',
				'value' => array(
					'default' => array($home_ignore_sticky_posts),
					'option' => array(
						0 => __( '可以置顶', 'momo' ),
						1 => __( '不置顶', 'momo' ),
					)

				)

			),
			array(
				'type' => 'checkbox',
				'th' => __('文章列表排除分类','momo'),
				'before' => '<p>'.__('选择排除的分类，留空则不排除任何分类','momo').'</p>',
				'key' => 'home_post_exclude',
				'value' => array(
					'default' => $home_post_exclude,
					'option' => $categories_array
				)
			)
		) );

		?>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '保存更改', 'momo' );?>"></p>

	</form>

</div>

	<?php

}

