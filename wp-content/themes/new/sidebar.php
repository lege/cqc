<aside class="sidebar">
<div class="menu pull-right">
			<form method="get" class="dropdown search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
				<input class="search-input" name="s" type="text" placeholder="Search..."<?php if( is_search() ){ echo ' value="'.$s.'"'; } ?> autofocus="" x-webkit-speech=""><input class="btn btn-success search-submit" type="submit" value="搜索" style=" width: 61px; ">
				<ul class="dropdown-menu search-suggest"></ul>
			</form>
		</div>
<div class="sidzr">
<h3 class="widget_tit">热门文章</h3>
<ul class="widgetbox">
 <?php $result = $wpdb->get_results("SELECT comment_count,ID,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 8");  
 foreach ($result as $post) {
 setup_postdata($post);
 $postid = $post->ID;
 $title = $post->post_title;
 $commentcount = $post->comment_count;
 if ($commentcount != 0) { ?>
 <li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>">
<?php echo $title ?></a></li>
 <?php } } ?></ul></div></div></div>
<div class="IndexLinkListWrap" id="youl">
		<div class="moketitle">友情链接</div>
		<ul>
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'pagemenu', 'echo' => false)) )); ?>
</ul></div>
<div id="blad">
				<button class="btn btn-primary" data-toggle="modal" data-target="#feed">订阅到邮箱</button>
				<?php if( dopt('d_tqq_b') || dopt('d_weibo_b') || dopt('d_facebook_b') || dopt('d_twitter_b') ){ ?>
				<?php } ?>
			<div class="sdad"><?php echo dopt('d_tui'); ?></div>
</div>
</aside>