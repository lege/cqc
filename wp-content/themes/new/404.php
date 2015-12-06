<?php get_header(); ?>
<div class="content-wrap">
	<div style="text-align:center;padding:60px 0;font-size:16px;">
		<h2 style="font-size:60px;margin-bottom:32px;">404 . Not Just An Error</h2>
		抱歉，沒有找到您需要的内容！！
	</div>
	<h1 class="page-title">给您推荐以下内容：</h1>
	<?php 
		$args = array(
		    'order'   => DESC,
		    'caller_get_posts' => 1,
		    'posts_per_page' => 4
		);
   		query_posts($args);
	?>
	<?php include( 'modules/excerpt.php' ); ?>
</div>
<?php get_footer(); ?>