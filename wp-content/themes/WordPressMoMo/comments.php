<?php
if ( post_password_required() ) { 
?>
	<div class="panel-body"><?php _e('This post is password protected. Enter the password to view comments.'); ?></div>
<?php

}else{

if ( have_comments() ) { ?>
	<ul class="list-group commentlist">
		<?php
		$s_comments = get_comments(array(
				'status' => 'approve',
				'post_id'=> $post->ID,
				'meta_key' => 'dmeng_sticky_comment',
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
			));


		$args = array(

		'status' => 'approve',

    'post_id' =>  $post->ID, // use post_id, not post_ID

'meta_key' => 'dmeng_sticky_comment',

);


$s_comments_num = get_comments($args);
		$s_comments_list = wp_list_comments("type=comment&callback=dmeng_comment&max_depth=1&echo=0&per_page=0", $s_comments );
		if($s_comments_list || ( get_current_user_id()==get_the_author_meta('ID') || current_user_can('moderate_comments') ) ){
		?>

		<ul id="sticky-comments">
			<li class="list-group-item sticky-title <?php if(!$s_comments_list) echo 'hide';?>"><span class="glyphicon glyphicon-arrow-up"></span><span class="respond-text"><?php echo get_option('dmeng_sticky_comment_title', __('置顶评论','momo')); ?>：共 <? echo count($s_comments_num);  ?> 条</span></li>
			<?php echo $s_comments_list;?>
		</ul>

		<?php } ?>
		
		<div class="index-tit">
			<div class="tit" style="font-size: 18px;"><?php echo get_comments_number() ?>条评论</div>
		</div>

		<ul id="thread-comments">
			<?php 
				//~ 强制评论嵌套，最少两级
				$depth = get_option('thread_comments_depth');
				$depth = intval($depth)<2 ? 2 : $depth;
				$depth = wp_is_mobile() ? 2 : $depth;
				wp_list_comments( "callback=dmeng_comment&style=ul&max_depth=$depth" );
				$paginate = dmeng_paginate_comments();
				if($paginate) echo '<li class="list-group-item text-center">'.$paginate.'</li>';
			?>
		</ul>


	</ul>


	


<?php } // if have comments 








if ( comments_open() ) { 


	


	?>
	



	


<div  id="respond">

		<div class="index-tit" >

			<div class="tit" style="font-size: 18px!important;"><?php comment_form_title( __('Leave a Reply'), __('Leave a Reply to %s' ) ); ?><small id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></small></div>
 
		</div>


	
	


<?php 


if ( get_option('comment_registration') && !is_user_logged_in() ){ 





?><p class="list-group-item"><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() . "#respond" )); ?></p>


<?php 





}else{





if( !empty($_GET['replytocom']) && is_numeric($_GET['replytocom']) ){


	//~ echo $_GET['replytocom'];


	wp_list_comments( 'type=comment&callback=dmeng_comment' , array( get_comment( $_GET['replytocom'] ) ) );


}


?><form action="<?php echo site_url(); ?>/wp-comments-post.php" method="post" id="commentform" class="form-horizontal" role="form">


	<?php if( get_option('comment_registration') && !is_user_logged_in() ) { ?>


		<p class="help-block"><a href="<?php echo wp_login_url( get_permalink() . "#respond" );?>"><?php _e('Log in to Reply');?></a></p>


	<?php } ?>


	<?php do_action( 'comment_form_top' );?>


	<div id="comment-user" data-user-id="<?php echo get_current_user_id();?>">


		<?php if ( is_user_logged_in() ) { ?>


			<p class="logged-in-help"><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_edit_user_link(), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php esc_attr_e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a></p>


		<?php } else { ?>


			<div class="form-group">


				


				


					<span class="glyphicon glyphicon-user" style="position: absolute;top: 11px;left: 24px;color: #DDD;"></span><input class="form-control" style="margin:0 15px;display:inline" type="text" name="author" id="author" title=""  value="<?php echo esc_attr($comment_author); ?>" placeholder="名称<?php if ($req) _e('（必填）','momo'); ?>" <?php if ($req) echo "aria-required='true' required"; ?> />


				


				<script>


jQuery(function ()


{ 


options={	    


		    trigger:'focus',


			placement:'right',


			title:'请输入您要显示在评论上方的昵称<?php if ($req) _e('（必填）','momo'); ?>'


		    };


jQuery("#author").tooltip(options);





});


</script>


			</div>


			<div class="form-group">


				


					


					<span class="glyphicon glyphicon-envelope" style="position: absolute;top: 11px;left: 24px;color: #DDD;"></span><input class="form-control" style="margin:0 15px;display:inline" type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="电子邮件<?php if ($req) _e('（必填）','momo'); ?>" <?php if ($req) echo "aria-required='true' required"; ?> />


					


				<script>


jQuery(function ()


{ 


options={	    


		    trigger:'focus',


			placement:'right',


			title:'请输入您的邮件地址<?php if ($req) _e('（必填）','momo'); _e('（不会被公开）','momo'); ?>',


		    };


jQuery("#email").tooltip(options);





});


</script>


			</div>


			<div class="form-group">


				


				<div class="">


						<span class="glyphicon glyphicon-home" style="position: absolute;top: 11px;left: 24px;color: #DDD;"></span><input class="form-control" style="margin:0 15px;display:inline"  title="请输入您的站点（选填）" type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" placeholder="站点"/>


				</div>


				<script>


jQuery(function ()


{ 


options={	    


		    trigger:'focus',


			placement:'right',


		    };


jQuery("#url").tooltip(options);





});


</script>


			</div>


		<?php } ?>


	</div>


	


	<textarea class="form-control" rows="3" name="comment" id="comment" placeholder="请输入内容..." required></textarea>


	<div id="comment-action" class="btn-toolbar clearfix" role="toolbar"><p class="help-block">


			<div class="btn-group">


				<div id="looks-image" class="hide">


					<ul class="clearfix">


			<?php


						$looks = dmeng_get_look('file');


						foreach( $looks['file'] as $lk=>$lf ){


							$look_title = str_replace(array('[',']'), '', $looks['text'][$lk]);


							echo '<li title="'.$look_title.'"><img src="'.wpmomo_script_uri('look') . $lf.'" alt="'.$look_title.'" width="22" height="22" /></li>';


						}


					?>


						</ul>


					</div>


						<div class="btn btn-default look-toggle" style="border-radius: 3px;"><span class="glyphicon glyphicon-asterisk"></span> <?php _e('表情','momo'); ?></div>


					<button class="btn btn-default" name="submit" type="submit" id="commentsubmit" style="margin-left:20px;"><span class="glyphicon glyphicon-print" style="margin-right: 10px;"></span><?php esc_attr_e('Submit Comment'); ?></button>


			


				


				


			</div>


		


	</div>


	<div class="input-group has-warning" id="privacy-action" style="display:none">


		<span class="input-group-addon"><?php echo  '<abbr class="pem" title="'.__('只有评论/文章作者或更高权限的用户才可见','momo').'">'.__('隐私内容','momo').'</abbr>'; ?></span>


		<input type="text" class="form-control" id="privacy-comment">


		<span class="input-group-btn">


			<button class="btn btn-warning" type="button" id="add-privacy-comment"><?php _e('添加到评论','momo'); ?></button>


		</span>


    </div>


	<div id="comment-error-alert" class="alert alert-warning" style="display:none;" role="alert"></div>


	<?php comment_id_fields(); ?>


	<?php do_action('comment_form', $post->ID); ?>


</form>


<?php } // If registration required and not logged in ?>


</div>





<?php }else{  ?>


	<div class="panel-body"><?php _e('Comments are closed.'); ?></div>


<?php





} // if comment open 








} // if post_password_required?>


