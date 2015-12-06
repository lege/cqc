<?php if(post_password_required()): ?>
<p>需要输入密码才能发表留言！</p>
<?php return;endif; ?>
<?php if(have_comments()): ?>
<?php global $comment_ids;$comment_ids=array();
foreach($comments as $comment){
if(get_comment_type()=="comment"){
$comment_ids[get_comment_id()]=++$comment_i;}} ?>
<?php if(get_comment_pages_count()>1&&get_option('page_comments')): ?>
<nav id="comment-nav-above">
  <div><?php previous_comments_link(' < '); ?></div>
  <div><?php next_comments_link(' > '); ?></div>
</nav>
<?php endif; ?>
<?php wp_list_comments(array('callback'=>'mytheme_comment')); ?>
<?php elseif(!comments_open()&&!is_page()&&post_type_supports(get_post_type(),'comments')): ?>
<?php endif; ?>
<?php if('open'==$post->comment_status): ?>
<?php endif; ?>
<?php if(get_option('comment_registration')&&!$user_ID): ?>
<p>需要登录才能发表留言！</p>
<?php endif; ?>
<div id="cancel_comment_reply"><?php cancel_comment_reply_link() ?></div>
<div class="pinglun" id="respond">
  <?php if(get_option('comment_registration')&&!$user_ID ): ?>
  <p><?php printf(__('需要 <a href="%s">登录</a> 才能发表留言'),get_option('siteurl')."/wp-login.php?redirect_to=".urlencode(get_permalink())); ?></p>
  <?php else: ?>
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" name="commentform">
    <?php if($user_ID): ?>
    <p><?php printf(__('当前用户：%s　'),'<a href="'.get_option('siteurl').'/wp-admin/profile.php"><font color="#f78585">'.$user_identity.'</font></a>'); ?><a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('退出') ?>"><?php _e('退出'); ?></a></p>
    <?php else: ?>
	<br />
    <div class="inputclass"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" /><label for="author" style="margin-right:12px;">昵称（必填）</label></div>
    <div class="inputclass"><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" /><label for="email" style="margin-right:12px;">邮箱（必填）</label></div>
    <div class="inputclass"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /><label for="url">主页</label></div>
    <?php endif; ?>
    <textarea name="comment" id="comment" tabindex="4" onblur="if(this.innerHTML==''){this.innerHTML='留言内容...';this.style.color=''}" onFocus="if(this.innerHTML=='留言内容...'){this.innerHTML='';this.style.color=''}">留言内容...</textarea>
    <input type="submit" class="submit" id="submit" tabindex="5" value="<?php echo attribute_escape(__('发表留言')); ?>" />
    <?php comment_id_fields(); ?>
    <?php do_action('comment_form', $post->ID); ?>
  </form>
  <?php endif; ?>
</div>