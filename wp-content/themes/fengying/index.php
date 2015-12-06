<?php get_header(); ?>

<div class="bodybox">
  <div class="main">
    <div class="common">
      <div class="list">
        <?php if(is_home()&&!is_paged()){ ?>
		<div class="sliderbox">
          <div class="slideshow">
<?php if(get_option('blog_slider_img1')!=""){ ?><a href="<?php echo get_option('blog_slider_url1'); ?>" title="<?php echo get_option('blog_slider_txt1'); ?>" target="_blank"><img src="<?php echo get_option('blog_slider_img1'); ?>" alt="<?php echo get_option('blog_slider_txt1'); ?>" width="850" height="358" /></a><?php } ?>
<?php if(get_option('blog_slider_img2')!=""){ ?><a href="<?php echo get_option('blog_slider_url2'); ?>" title="<?php echo get_option('blog_slider_txt2'); ?>" target="_blank"><img src="<?php echo get_option('blog_slider_img2'); ?>" alt="<?php echo get_option('blog_slider_txt2'); ?>" width="850" height="358" /></a><?php } ?>
<?php if(get_option('blog_slider_img3')!=""){ ?><a href="<?php echo get_option('blog_slider_url3'); ?>" title="<?php echo get_option('blog_slider_txt3'); ?>" target="_blank"><img src="<?php echo get_option('blog_slider_img3'); ?>" alt="<?php echo get_option('blog_slider_txt3'); ?>" width="850" height="358" /></a><?php } ?>
<?php if(get_option('blog_slider_img4')!=""){ ?><a href="<?php echo get_option('blog_slider_url4'); ?>" title="<?php echo get_option('blog_slider_txt4'); ?>" target="_blank"><img src="<?php echo get_option('blog_slider_img4'); ?>" alt="<?php echo get_option('blog_slider_txt4'); ?>" width="850" height="358" /></a><?php } ?>
<?php if(get_option('blog_slider_img5')!=""){ ?><a href="<?php echo get_option('blog_slider_url5'); ?>" title="<?php echo get_option('blog_slider_txt5'); ?>" target="_blank"><img src="<?php echo get_option('blog_slider_img5'); ?>" alt="<?php echo get_option('blog_slider_txt5'); ?>" width="850" height="358" /></a><?php } ?>
<?php if(get_option('blog_slider_img6')!=""){ ?><a href="<?php echo get_option('blog_slider_url6'); ?>" title="<?php echo get_option('blog_slider_txt6'); ?>" target="_blank"><img src="<?php echo get_option('blog_slider_img6'); ?>" alt="<?php echo get_option('blog_slider_txt6'); ?>" width="850" height="358" /></a><?php } ?>
		  </div>
          <div class="slidernav">
            <ul>
<?php if(get_option('blog_slider_img1')!=""){ ?><li><a href="#"></a></li><?php } ?>
<?php if(get_option('blog_slider_img2')!=""){ ?><li><a href="#"></a></li><?php } ?>
<?php if(get_option('blog_slider_img3')!=""){ ?><li><a href="#"></a></li><?php } ?>
<?php if(get_option('blog_slider_img4')!=""){ ?><li><a href="#"></a></li><?php } ?>
<?php if(get_option('blog_slider_img5')!=""){ ?><li><a href="#"></a></li><?php } ?>
<?php if(get_option('blog_slider_img6')!=""){ ?><li><a href="#"></a></li><?php } ?>
            </ul>
          </div>
        </div>
        <?php } ?>
		<div class="articlebox">
          <ul>
            <?php global $query_string;query_posts($query_string.'&ignore_sticky_posts=1');$postnun=1;if(have_posts()):while(have_posts()):the_post();?>
			<li class="articlelist">
              <div class="thumbnail"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank"><?php if(has_post_thumbnail()){ ?><?php the_post_thumbnail('thumbnail'); ?><?php }else{ ?><img src="<?php bloginfo('template_url'); ?>/images/nopic.jpg" alt="<?php the_title(); ?>" width="280" height="180" /><?php } ?></a></div>
              <div class="tilte">
                <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></h2>
                <?php if(is_sticky()){ ?><span>推荐</span><?php } ?>
              </div>
              <div class="info">
                <div class="category"><?php the_category('') ?></div>
                <div class="author"><?php the_author_posts_link(); ?></div>
                <div class="date"><?php the_time('Y-m-d') ?></div>
                <div class="view"><?php echo getPostViews(get_the_ID()); ?></div>
                <div class="comment"><?php comments_number('0','1','%');?></div>
              </div>
              <div class="summary">
                <?php the_excerpt(); ?>
              </div>
              <div class="tag"><?php the_tags('','',''); ?></div>
            </li>
			<?php $postnun++; endwhile; else: ?>
			<li class="articlelist">
			  <div class="nothing">抱歉，暂无相关内容！</div>
			</li>
			<?php endif; ?>
          </ul>
          <?php par_pagenavi(9); ?>
        </div>
      </div>
      <div class="sidebar">
        <?php if(is_home()&&!is_paged()){ ?>
		<div class="social">
          <ul>
            <li class="sinaweibo"><a href="<?php echo get_option('blog_sinaweibo'); ?>" title="新浪微博" rel="external nofollow" target="_blank"></a></li>
            <li class="tencentweibo"><a href="<?php echo get_option('blog_tencentweibo'); ?>" title="腾讯微博" rel="external nofollow" target="_blank"></a></li>
            <li class="qq"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo get_option('blog_qq'); ?>&site=qq&menu=yes" title="联系QQ" rel="external nofollow" target="_blank"></a></li>
            <li class="weixin"><a title="微信二维码"></a>
			  <div class="weixinimg"><img alt="微信二维码" src="<?php bloginfo('template_url'); ?>/images/weixinimg.jpg" width="280" height="280" /></div>
			</li>
            <li class="rss"><a href="<?php echo get_option('blog_rss'); ?>" title="订阅本站" rel="external nofollow" target="_blank"></a></li>
          </ul>
        </div>
        <?php if(get_option('blog_about')!=""){ ?>
		<div class="widgets">
		  <div class="widgetstitle">关于本站</div>
		  <div class="about"><?php echo get_option('blog_about'); ?></div>
		</div>
		<?php } ?>
		<?php } ?>
		<?php if(is_dynamic_sidebar())dynamic_sidebar('right_sidebar'); ?>
        <div class="widgets" id="float">
          <div class="adbox">
            <div class="adimg">
              <ul>
<?php if(get_option('blog_ad1')!=""){ ?><li><?php echo get_option('blog_ad1'); ?></li><?php } ?>
<?php if(get_option('blog_ad2')!=""){ ?><li><?php echo get_option('blog_ad2'); ?></li><?php } ?>
<?php if(get_option('blog_ad3')!=""){ ?><li><?php echo get_option('blog_ad3'); ?></li><?php } ?>
<?php if(get_option('blog_ad4')!=""){ ?><li><?php echo get_option('blog_ad4'); ?></li><?php } ?>
<?php if(get_option('blog_ad5')!=""){ ?><li><?php echo get_option('blog_ad5'); ?></li><?php } ?>
<?php if(get_option('blog_ad6')!=""){ ?><li><?php echo get_option('blog_ad6'); ?></li><?php } ?>
              </ul>
              <a href="javascript:;" class="btn_prev"></a><a href="javascript:;" class="btn_next"></a>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
<?php get_footer(); ?>