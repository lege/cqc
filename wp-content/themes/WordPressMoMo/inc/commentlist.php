<?php


/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言
 */




/*
 * 评论列表
 */
 
 


function dmeng_comment($comment, $args, $depth) {


	$GLOBALS['comment'] = $comment;


	extract($args, EXTR_SKIP);


	


	$sticky = get_comment_meta( $comment->comment_ID, 'dmeng_sticky_comment', true );





	$tag = 'li';


	$add_below = $sticky&&$args['echo']==0 ? 'sticky-comment' : 'comment';


	


	$add_comment_class = empty( $args['has_children'] ) ? '' : ' parent';


	if ( $comment->comment_approved == 0 ) $add_comment_class .= ' children';


	if ( $comment->comment_parent == 0 ) $add_comment_class .= ' top';





	$avatar_size = 40;


	if($depth<=1) $avatar_size = 50;


	


	$attr_id = $sticky&&$args['echo']==0 ? 'sticky-comment-'.$comment->comment_ID : 'comment-'.$comment->comment_ID;


	$attr_class = $sticky&&$args['echo']==0 ? 'class="comment sticky-comment"' : comment_class( $add_comment_class, $comment->comment_ID, $comment->comment_post_ID , false );


	


	$author_url = $comment->comment_author_url;


	$user_exists = false;


	$display_name = $comment->user_id ? get_the_author_meta( 'display_name', $comment->user_id ) : '';


	if($display_name){


		$author_url = get_author_posts_url( $comment->user_id );


		$author_link = get_the_author_meta( 'user_url', $comment->user_id );


		$author_link = $author_link ? $author_link : $author_url;


		$author_link = '<a href="'.$author_link.'" rel="external nofollow" target="_blank">'.$display_name.'</a>';


		$user_exists = true;


	}else{


		$author_link = $comment->comment_author_url ? '<a href="'.$comment->comment_author_url.'" rel="external nofollow" target="_blank">'.$comment->comment_author.'</a>' : $comment->comment_author;


	}


	


	if(empty($author_link)) $author_link = __('匿名','momo');


	$author_link = apply_filters( 'get_comment_author_link', $author_link );


	$author_name = '<cite ';


	if($user_exists) $author_name .= 'class="fn" ';


	$author_name .= '>'.$author_link.'</cite>';





	if( current_time('timestamp') - get_comment_time('U') < 86400 ){


		$comment_time = sprintf( __('%s前','momo'), human_time_diff( get_comment_time('U'), current_time('timestamp') ) );


	}else{


		$comment_time = sprintf( __('%1$s at %2$s'), get_comment_date('Y-m-d'),  get_comment_time('H:i') );


	}



	$comment_time = '<time datetime="'.get_comment_date('Y-m-d').'" title="'.sprintf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ).'">'.$comment_time.'</time>';


	global $comment_depth;


	$comment_parent = '';

	if($comment_depth>=$args['max_depth']&&$args['echo']!=0){


		$comment_parent = '<span class="top-level">'.__( 'Reply' ).get_comment($comment->comment_parent)->comment_author.' :</span> ';


		//~ $comment_parent = '<a href="'.htmlspecialchars( get_comment_link( $comment->comment_parent ) ).'" class="top-level">'.__( 'Reply' ).get_comment($comment->comment_parent)->comment_author.' :</a> ';


	}


?><li <?php echo $attr_class;?> id="<?php echo $attr_id;?>" data-comment-id="<?php echo $comment->comment_ID;?>">


<?php





if ( in_array($comment->comment_type, array('pingback', 'trackback') ) ) {


	


	echo $comment_time . __(' 链接通知 : ','momo') . $author_name; 





}else{


	


if ( $comment->comment_parent == 0 ) dmeng_vote_html('comment',$comment->comment_ID);





if ( get_option('show_avatars') ) { ?>


	<a class="comment-author" href="<?php echo $author_url ? $author_url : 'javascript:;'; ?>" data-instant><?php


	


		echo dmeng_get_avatar( 


									( !empty($comment->user_id) ? $comment->user_id : $comment->comment_author_email ), 


									$avatar_size, 


									( !empty($comment->user_id) ? dmeng_get_avatar_type($comment->user_id) : 'default' ), 


									true


								); 


								


	?></a>


	


<?php } ?>





	<div class="comment-body">


		<?php echo $author_name;  	?>


		


		<span class="comment-meta">


			<?php 


		


		//~ 评论时间


		echo $comment_time; 


		


		//~ 回复链接


		comment_reply_link( array_merge( $args, array( 'reply_text' => '<span class="glyphicon glyphicon-transfer"></span>' . __( 'Reply' ),  'login_text' => '<span class="glyphicon glyphicon-transfer"></span>' . __('Log in to Reply'), 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => 999999999 ) ) );





		//~ 私信链接


		if($user_exists && get_current_user_id()!=$comment->user_id){


			echo '<a class="pm" href="'.add_query_arg('tab', 'message', $author_url).'" title="'.__('私信','momo').'" target="_blank"><span class="glyphicon glyphicon-share-alt"></span>'.__('私信','momo').'</a>';


		}


			


		//~ 置顶链接
			$button_txt = get_option('dmeng_sticky_comment_button_txt',__('置顶','momo'));
			
			$button_txt_cancel = get_option('dmeng_sticky_comment_button_txt_cancel',__('取消置顶','momo'));

		if( is_user_logged_in() && ( get_current_user_id()==get_the_author_meta('ID') || current_user_can('moderate_comments') ) ) {


			printf('<a href="javascript:;" class="comment-sticky %s"><span class="glyphicon %s"></span>%s</a>', $comment->comment_ID.($sticky ? ' active' : ''), ($sticky ? ' glyphicon-arrow-down' : ' glyphicon-arrow-up'),($sticky ? $button_txt_cancel :   $button_txt ) );


		}


			


		//~ 编辑链接


		edit_comment_link(  '<span class="glyphicon glyphicon-edit"></span>' . __( 'Edit' ), '  ', '' );	


			 


			


			


			?>


			


				</span>


		<div class="comment-content"><?php echo $comment_parent;?><?php echo wpautop(get_comment_text());?></div>



	<?php if ( $comment->comment_approved == '0' ) : ?>


		<span class="text-danger"><?php _e( 'Your comment is awaiting moderation.' ); ?></span>


	<?php endif; ?>


	</div>


<?php } 





?></li>


<?php


}


