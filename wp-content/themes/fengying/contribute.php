<?php
/*
Template Name:游客投稿
*/
if(isset($_POST['contributeform'])&&$_POST['contributeform']=='send'){
    global $wpdb;
    $last_post=$wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_type = 'post' ORDER BY post_date DESC LIMIT 1");
    if(current_time('timestamp')-strtotime($last_post)<60){wp_die('投稿间隔应至少为1分钟！');}
    $name=isset($_POST['authorname'])?trim(htmlspecialchars($_POST['authorname'],ENT_QUOTES)):'';
    $email=isset($_POST['authoremail'])?trim(htmlspecialchars($_POST['authoremail'],ENT_QUOTES)):'';
    $url=isset($_POST['authorurl'])?trim(htmlspecialchars($_POST['authorurl'],ENT_QUOTES)):'';
    $title=isset($_POST['articletitle'])? trim(htmlspecialchars($_POST['articletitle'],ENT_QUOTES)):'';
    $category=isset($_POST['cat'])?(int)$_POST['cat']:0;
    $content=isset($_POST['articlecontent'])?trim(htmlspecialchars($_POST['articlecontent'],ENT_QUOTES)):'';
    if(empty($name)||mb_strlen($name)>30){wp_die('作者笔名必须填写，且长度不能超过30个字符！');}
    if(empty($email)||strlen($email)>60||!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email)){wp_die('作者邮箱必须填写，且长度不能超过60个字符，并符合邮箱格式！');}
    if(empty($title)||mb_strlen($title)>120){wp_die('文章标题必须填写，且长度不能超过120个字符！');}
    if(empty($content)||mb_strlen($content)>20000||mb_strlen($content)<100){wp_die('文章内容必须填写，且长度不能超过20000个字符，不能少于100个字符！');}
    $post_content='作者笔名：'.$name.'<br />作者邮箱：'.$email.'<br />作者主页：'.$url.'<br />文章内容：<br />'.$content;
    $contribute=array('post_title'=>$title,'post_content'=>$post_content,'post_category'=>array($category));
    $status=wp_insert_post($contribute);
    if($status!=0){
	  wp_mail(''.get_option('blog_mail_username').'',''.get_option('blogname').'游客投稿','您的'.get_option('blogname').'有游客投稿！');
      wp_die('投稿成功，您的文章将在审核通过后发布！','投稿成功');}
    else{wp_die('投稿失败');}}
?>
<?php get_header(); ?>

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
		  <div class="clear"></div>
          <div class="contenttxt">
            <?php the_content(); ?>
			<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
			<div class="contributebox">
			  <div class="inputclass"><input type="text" name="authorname" id="authorname" value="" /><label for="authorname">作者笔名（必填）</label></div>
			  <div class="inputclass"><input type="text" name="authoremail" id="authoremail" value="" /><label for="authoremail">作者邮箱（必填）</label></div>
			  <div class="inputclass"><input type="text" name="authorurl" id="authorurl" value="" /><label for="authorurl">作者主页</label></div>
			  <div class="inputclass"><input type="text" name="articletitle" id="articletitle" value="" /><label for="articletitle">文章标题（必填）</label></div>
			  <div class="inputclass"><?php wp_dropdown_categories('show_count=1&hierarchical=1'); ?><label for="cat">文章分类（必选）</label></div>
			  <textarea name="articlecontent" id="articlecontent" onblur="if(this.innerHTML==''){this.innerHTML='文章内容...';this.style.color=''}" onFocus="if(this.innerHTML=='文章内容...'){this.innerHTML='';this.style.color=''}">文章内容...</textarea>
			  <input type="hidden" value="send" name="contributeform" />
			  <input type="submit" class="contributesubmit" id="contributesubmit" value="确认投稿" />
			</div>
			</form>
          </div>
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