<?php get_header(); ?>

<?php setPostViews(get_the_ID()); ?>
<div class="bodybox">
  <div class="main">
    <div class="common">
      <?php if(have_posts()):while(have_posts()):the_post(); ?>
	  <div class="list">
        <div class="position">
          <div class="positiontxt"><?php if(function_exists('wp_breadcrumbs')){wp_breadcrumbs();} ?></div>
        </div>
		<div class="contentbox">
          <div class="contenttitle">
            <h1><?php the_title(); ?></h1>
		  </div>
          <div class="contentview">浏览次数<span><?php echo getPostViews(get_the_ID()); ?></span></div>
		  <div class="clear"></div>
          <div class="contenttxt">
            <?php the_content(); ?>
          </div>
        </div>
        <div class="commentsbox">
	      <div class="commentsnum">全部评论：<?php comments_number('<span>0</span>条','<span>1</span>条','<span>%</span>条','','评论已关闭'); ?></div>
	      <?php comments_template('',true); ?>
        </div>
      </div>
	  <?php endwhile; endif;?>
      <div class="sidebar">
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