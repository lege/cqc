<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
			<div class="meta">
				<time class="muted"><i class="ico icon-time icon12" style=" margin-top: 1px; "></i> <?php the_time('Y.m.d');?></time><?php  
					$category = get_the_category();
			        if($category[0]){
			            echo '<span class="muted"><a href="'.get_category_link($category[0]->term_id ).'"><i class="icon-list-alt icon12"></i> '.$category[0]->cat_name.'</a></span>';
			        }
				?>
				
				<span class="muted"><i class="ico icon-eye-open icon12"></i> <?php deel_views(' Views'); ?></span>
				<?php if ( comments_open() ) echo '<span class="muted"><i class="icon-comment icon12"></i> <a href="'.get_comments_link().'">'.get_comments_number('去', '1', '%').' Comments</a></span>'; ?>
				<?php edit_post_link('[编辑]'); ?>
			</div>
		</header>

		<?php if( dopt('d_adpost_01_b') ) echo '<div class="banner banner-post">'.dopt('d_adpost_01').'</div>'; ?>
		
		<article class="article-content">
			<?php the_content(); ?>
		</article>

		<?php endwhile;  ?>

		<footer class="article-footer">
			
			<div id="baidshare">
			<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_t163" data-cmd="t163" title="分享到网易微博"></a><a href="#" class="bds_baidu" data-cmd="baidu" title="分享到百度搜藏"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_tqf" data-cmd="tqf" title="分享到腾讯朋友"></a><a href="#" class="bds_bdhome" data-cmd="bdhome" title="分享到百度新首页"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a><a href="#" class="bds_tsohu" data-cmd="tsohu" title="分享到搜狐微博"></a><a href="#" class="bds_thx" data-cmd="thx" title="分享到和讯微博"></a><a href="#" class="bds_taobao" data-cmd="taobao" title="分享到我的淘宝"></a><a href="#" class="bds_qq" data-cmd="qq" title="分享到QQ收藏"></a><a href="#" class="bds_bdysc" data-cmd="bdysc" title="分享到百度云收藏"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_hi" data-cmd="hi" title="分享到百度空间"></a><a href="#" class="bds_msn" data-cmd="msn" title="分享到MSN"></a><a href="#" class="bds_sohu" data-cmd="sohu" title="分享到搜狐白社会"></a><a href="#" class="bds_mogujie" data-cmd="mogujie" title="分享到蘑菇街"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","t163","baidu","tieba","tqf","bdhome","sqq","tsohu","thx","taobao","qq","bdysc","douban","hi","msn","sohu","mogujie","meilishuo","qy","leho","mshare","huaban","share189","hx","diandian"],"viewText":"分享到：","viewSize":"32"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":false}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=86326610.js?cdnversion='+~(-new Date()/36e5)];</script>
			</div>
		</footer>

		<div class="relates">
			<?php include( 'modules/related.php' ); ?>
		</div>

		<?php if( dopt('d_adpost_02_b') ) echo '<div class="banner banner-related">'.dopt('d_adpost_02').'</div>'; ?>

		<?php comments_template('', true); ?>

	</div>
</div>
<?php get_sidebar(); get_footer(); ?>