<?php



/*

 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言

 */



/*

 * 投票

 * 

 */

 

/*

 * 

 * 获取投票数

 * 

 */



function get_dmeng_user_vote( $uid, $count=true, $type='', $vote='', $limit=0, $offset=0 ){



	$uid = intval($uid);

	

	if( !$uid ) return;

	

	$type = in_array($type, array('post', 'comment')) ? $type : '';

	$vote = in_array($vote, array('up', 'down')) ? $vote : '';

	

	global $wpdb;

	$table_name = $wpdb->prefix . 'dmeng_meta';



	$where = "WHERE user_id='$uid' ";

	

	if($type) {

		$vote_type = 'vote_'.$type.'_%';

		$where .= "AND meta_key LIKE '$vote_type' ";

	}

	

	if($vote) $where .= "AND meta_value LIKE '$vote' ";



	if($count){

		$check = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $where" );

	}else{

		$field = $vote ? 'meta_key' : 'meta_key,meta_value';

		$check = $wpdb->get_results( "SELECT $field FROM $table_name $where ORDER BY meta_id DESC LIMIT $offset,$limit" );

	}

	

	if($check)	return $check;

	

	return 0;

}

 

/*

 * 

 * 投票HTML

 * 

 */

 

function dmeng_vote_html($type,$id){

	

	$type = $type=='post' ? 'post' : 'comment';

	$vote_class = 'col-sm-6 col-xs-12 vote-group';

	$up_class = 'up';

	$down_class = 'down';

	$up_html = '<span class="glyphicon glyphicon-star" style="top:3px;margin-right:5px;font-size:16px"></span>';

	$down_html = '<span class="glyphicon glyphicon-remove"   style="top:3px;margin-right:5px;font-size:16px"></span>';

	$type_html = 'data-vote-type="post" itemscope itemtype="http://data-vocabulary.org/Review-aggregate"';

	if($type=='comment'){
		$vote_class = 'comment-votes vote-group';
		$up_class = 'up';
		$down_class = 'down';
		$up_html = '<span class="glyphicon glyphicon-hand-up"></span>';
		$down_html = '<span class="glyphicon glyphicon-hand-down" ></span>';
		$type_html = '';
	}

	$key = 'vote_'.$type.'_'.$id;
	$uid = get_current_user_id();
	if($uid>0){

		$vote = get_dmeng_meta($key,$uid);
		if($vote){
			$vote_class .= ' disabled';
			if($vote=='up') $up_class .= ' highlight';
			elseif($vote=='down') $down_class .= ' highlight';
		}
	}

	if($type==='post'||$type==='comment'){
		$votes_up = (int)get_metadata($type, $id, 'dmeng_votes_up', true);
		$votes_down = (int)get_metadata($type, $id, 'dmeng_votes_down', true);
	}
	$votes = $votes_up-$votes_down;

?><div class="<?php echo $vote_class;?>" data-votes-up="<?php echo $votes_up;?>" data-votes-down="<?php echo $votes_down;?>" data-vote-id="<?php echo $id; ?>" <?php echo $type_html; ?>>


<a href="javascript:;" class="<?php echo $up_class;?>"><?php echo $up_html;?><?php  if($type=='post')echo $votes_up.' 喜欢'  ?></a>

 <?php  if($type=='comment'): ?> <span class="votes" style="margin:0 8px 0 5px;color: #ACACAC;"><?php echo $votes;?></span> <?php endif ?>

 

 <?php



if($type=='post'){
	$count = $votes_up+$votes_down;
	//~ 投票计算得分，最低1分，最高10分，四舍五入留一个小数点（用于微数据 for microdata）
	$rating = ($votes_up+$votes_down)>0 ? round($votes_up/($votes_up+$votes_down)*5, 1) : 0;
	if($rating<1) $rating = 1;
	echo '<div class="hide" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating"><span itemprop="average">'.$rating.'</span><span itemprop="votes">'.$count.'</span><span itemprop="count">'.get_comments_number().'</span></div>';
}

?>
<a href="javascript:;" class="<?php echo $down_class;?>"><?php echo $down_html;?><?php  if($type=='post')echo $votes_down.' 讨厌'   ?></a>
</div><?php
}

 

/*

 * 

 * 投票AJAX

 * 

 */

 

function dmeng_vote_ajax_callback(){



	do_action( 'dmeng_before_ajax', false, false );

	

	if ( !isset($_POST['type']) || !isset($_POST['id']) || !isset($_POST['vote']) ) return;

	

	$type = sanitize_text_field($_POST['type']);

	$id = intval($_POST['id']);

	$vote = sanitize_text_field($_POST['vote']);



	$key = 'vote_'.$type.'_'.$id;

	$uid = get_current_user_id();

	

	if($uid===0){

	

		add_dmeng_meta($key,$vote,$uid);



	}else{

		

		update_dmeng_meta($key,$vote,$uid);

		

	}

	

	//~ 为了便于列表应用和排序，up和down各保存一个总数到wordpress的原有meta表(postmeta/commentmeta)

	if($type==='post'||$type==='comment'){

		if($vote=='up') update_metadata($type, $id, 'dmeng_votes_up', (int)get_dmeng_meta_count($key,'up'));

		if($vote=='down') update_metadata($type, $id, 'dmeng_votes_down', (int)get_dmeng_meta_count($key,'down'));

	}

	

	echo 'ok';



	die();

}

add_action( 'wp_ajax_dmeng_vote_ajax', 'dmeng_vote_ajax_callback' );

add_action( 'wp_ajax_nopriv_dmeng_vote_ajax', 'dmeng_vote_ajax_callback' );

