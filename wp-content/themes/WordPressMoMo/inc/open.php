<?php

/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦
 *

/*
 * 开放平台
 * 
 */
 
//~ 拒绝搜索引擎索引开放平台登录地址
function dmeng_connect_robots_mod( $output, $public ){
	$output .= "Disallow: /?connect=*";
	return $output;
}
add_filter( 'robots_txt', 'dmeng_connect_robots_mod', 10, 2 );

function dmeng_is_open_qq($user_id=0){
	$open_qq = (int)get_option('dmeng_open_qq',1);
	if($open_qq!==1) return false;
	$id = (int)$user_id;
	$O = array(
		'ID'=>get_option('dmeng_open_qq_id'),
		'KEY'=>get_option('dmeng_open_qq_key')
	);
	if( !$O['ID'] || !$O['KEY'] ) return false;
	if($id){
		$U = array(
			'ID'=>get_user_meta( $id, 'dmeng_qq_openid', true ),
			'TOKEN'=>get_user_meta( $id, 'dmeng_qq_access_token', true )
		);
		if( !$U['ID'] || !$U['TOKEN'] ) return false;
	}
	return true;
}

function dmeng_is_open_weibo($user_id=0){

	$open_weibo = (int)get_option('dmeng_open_weibo',1);
	if($open_weibo!==1) return false;
	$id = intval($user_id);
	$O = array(
		'KEY'=>get_option('dmeng_open_weibo_key'),
		'SECRET'=>get_option('dmeng_open_weibo_secret')
	);

	if( !$O['KEY'] || !$O['SECRET'] ) return false;

	if($id){
		$U = array(
			'ID'=>get_user_meta( $id, 'dmeng_weibo_openid', true ),
			'TOKEN'=>get_user_meta( $id, 'dmeng_weibo_access_token', true )
		);
		if( !$U['ID'] || !$U['TOKEN'] ) return false;
	}
	return true;
}

function dmeng_check_auto_userlogin($type='', $user_id, $user_login=''){
	
	if( !in_array($type, array('qq', 'weibo') ) ) return false;
	
	$id = intval($user_id);
	
	if(empty($id)){
		$id = get_current_user_id();
	}
	
	$openid = get_user_meta( $id, 'dmeng_'.$type.'_openid', true );
	
	if(empty($openid)) return false;

	if(empty($user_login)){
		$user = get_user_by( 'id', $id );
		$user_login = $user->user_login;
	}

	if( $user_login == strtoupper(substr( $type, 0, 1 )).$openid ) return true;
	
	return false;

}

function dmeng_get_open_login_url($type='qq', $action='login', $redirect=''){
	$type = $type=='qq' ? 'qq' : 'weibo';
	if($action=='login'){
		$nonce = wp_create_nonce('check-open');
	}else{
		$action=='logout';
		$nonce = wp_create_nonce('check-open-logout');
	}
	
	$path = '/?connect='.$type.'&action='.$action.'&_wpnonce='.$nonce;
	if( $redirect ) $path .= '&redirect='.urlencode($redirect);
	return home_url($path);
}

function dmeng_login_form(){
	$open_data = array();
	if( dmeng_is_open_weibo() ) {
		$open_data[] = array(
			'title' => __('微博', 'momo'),
			'slug' => 'weibo'
		);
	}
	if( !$open_data ) return;
	?>
	<style>
		.dmeng-open{list-style:none;padding:0;margin:0;}
		.dmeng-open li a{display:block;line-height: 32px;text-indent: 39px;margin: 0 0 10px 0;padding: 5px;background-color: #f5f5f5;background-repeat: no-repeat;background-position:7px 5px;}
		.dmeng-open li a.qq{background-image:url(<?php bloginfo('template_url');?>/images/qq_32x32.png);}
		.dmeng-open li a.weibo{background-image:url(<?php bloginfo('template_url');?>/images/weibo_32x32.png);}
	</style>
<ul class="dmeng-open">
	<?php
		foreach( $open_data as $open ){
			echo '<li><a class="'.$open['slug'].'" href="'.dmeng_get_open_login_url($open['slug'], 'login', dmeng_get_redirect_uri()).'">'.sprintf( __('使用%s账号登录', 'momo'), $open['title']).'</a> </li>';
		}
	?>
</ul>
	<?php
}
add_action('login_form', 'dmeng_login_form');
add_action('register_form', 'dmeng_login_form');

function open_user_contactmethods($user_contactmethods ){
	$user_contactmethods ['dmeng_qq_openid'] = 'QQ OPEN ID';
	$user_contactmethods ['dmeng_qq_access_token'] = 'QQ TOKEN';
	$user_contactmethods ['dmeng_weibo_openid'] = 'WEIBO OPEN ID';
	$user_contactmethods ['dmeng_weibo_access_token'] = 'WEIBO TOKEN';
	return $user_contactmethods ;
}
//~ add_filter('user_contactmethods','open_user_contactmethods');

add_action( 'profile_personal_options', 'dmeng_open_profile_fields' );
function dmeng_open_profile_fields( $user ) {
	$qq = dmeng_is_open_qq();
	$weibo = dmeng_is_open_weibo();

	if( $qq || $weibo ) {
    ?>
<table class="form-table">
	
	<?php if($qq){ ?>
	<tr>
		<th scope="row"><?php _e('QQ登录','momo');?></th>
		<td>
	<?php  if(dmeng_is_open_qq($user->ID)) { ?>
		<p><?php _e('已绑定','momo');?> <a href="<?php echo dmeng_get_open_login_url('qq', 'logout'); ?>"><?php _e('点击解绑','momo');?></a></p>
		<?php echo dmeng_get_avatar( $user->ID , '100' , 'qq', false ); ?>
	<?php }else{ ?>
		<a class="button button-primary" href="<?php echo dmeng_get_open_login_url('qq', 'login'); ?>"><?php _e('绑定QQ账号','momo');?></a>
	<?php } ?>
		</td>
	</tr>
	<?php } ?>
	
	<?php if($weibo){ ?>
	<tr>
		<th scope="row"><?php _e('微博登录','momo');?></th>
		<td>
	<?php if(dmeng_is_open_weibo($user->ID)) { ?>
		<p><?php _e('已绑定','momo');?> <a href="<?php echo dmeng_get_open_login_url('weibo', 'logout'); ?>"><?php _e('点击解绑','momo');?></a></p>
		<?php echo dmeng_get_avatar( $user->ID , '100' , 'weibo', false ); ?>
	<?php }else{ ?>
		<a class="button button-primary" href="<?php echo dmeng_get_open_login_url('weibo', 'login'); ?>"><?php _e('绑定微博账号','momo');?></a>
	<?php } ?>
		</td>
	</tr>
	<?php } ?>
	
</table>

    <?php
	}
}

$OPEN_QQ = array(
	'APPID'=>get_option('dmeng_open_qq_id'),
	'APPKEY'=>get_option('dmeng_open_qq_key'),
	'CALLBACK'=>home_url('/?connect=qq')
);

$OPEN_WEIBO = array(
	'KEY'=>get_option('dmeng_open_weibo_key'),
	'SECRET'=>get_option('dmeng_open_weibo_secret'),
	'CALLBACK'=>home_url('/?connect=weibo')
);

function dmeng_open_template_redirect(){
	
	$redirect = dmeng_get_redirect_uri();
	
	$die_title = '请重试或报告管理员';
			
	$redirect_text = '<p>'.$die_title.' </p><p><a href="'.$redirect.'">点击返回</a></p>';

	$user_ID = get_current_user_id();
	
	function dmeng_open_login($openid='',$token='',$type='qq',$name=''){
		
		$redirect = isset($_COOKIE['dmeng_logged_in_redirect']) ? urldecode($_COOKIE['dmeng_logged_in_redirect']) : home_url();
		
		$die_title = '请重试或报告管理员';
				
		$redirect_text = '<p>'.$die_title.' </p><p><a href="'.$redirect.'">点击返回</a></p>';

		$user_ID = get_current_user_id();
		
			$id_field = 'dmeng_'.$type.'_openid';
			$token_field = 'dmeng_'.$type.'_access_token';
			
			global $wpdb;

			$user_exist = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='$id_field' AND meta_value='$openid' " );
			
			if(is_user_logged_in()){
				
				if( isset($user_exist) && (int)$user_exist>0 ){
					
					wp_die($name.' 已有绑定账号，请绑定其他账号或先解除原有账号。 '.$redirect_text  , $die_title , array( 'response'=>503 ) );
					
				}else{
				
				update_user_meta($user_ID, $id_field, $openid);
				update_user_meta($user_ID,$token_field, $token);
				header('Location:'.$redirect);
				exit;
				
				}
			
			}else{
				
				if( isset($user_exist) && (int)$user_exist>0 ){
				
					$insert_user_id = $user_exist;
					$is_new_user = 0;
				
				}else{

					$user_login = strtoupper(substr( $type, 0, 1 )).$openid;

					$insert_user_id = wp_insert_user( array(
						'user_login'  => $user_login,
						'nickname'  => $name,
						'display_name'  => $name,
						'user_pass' => wp_generate_password()
					) ) ;
	
					$is_new_user = 1;
	
				}
				
				if( is_wp_error($insert_user_id) ) {

					wp_die(__('登录失败！ ', 'momo'). $redirect_text . '<br> [ '. $insert_user_id->get_error_message() .' ] ' , $die_title , array( 'response'=>503 ) );
					
				}else{

					update_user_meta($insert_user_id, $id_field, $openid);
					update_user_meta($insert_user_id, $token_field, $token);
					
					if( $is_new_user ){
						update_user_meta($insert_user_id, 'dmeng_avatar', $type);
						wp_update_user( array ('ID' => $insert_user_id, 'role' => get_option('dmeng_open_role', 'contributor') ) );
						add_dmeng_message( $insert_user_id, 'unread', current_time('mysql'), __('请完善账号信息','momo'), sprintf(__('欢迎来到%1$s，请<a href="%2$s">完善资料</a>，其中电子邮件尤为重要，许多信息都将通过电子邮件通知您！','momo') , get_bloginfo('name'), admin_url('profile.php')) );
					}

					wp_set_current_user( $insert_user_id, $user_login );
					wp_set_auth_cookie( $insert_user_id, intval(get_option('dmeng_open_remember_the_user',1)) );

					$user = get_user_by( 'id', $insert_user_id );
					do_action( 'wp_login', $user->user_login, $user );
    
					header('Location:'.$redirect);
					exit;
					
				}
					
			}
	}
	
	function dmeng_open_logout($type='qq'){
		
		$redirect = get_edit_profile_url();
		
		if($type==='qq'){
			$type = 'qq';
			$name = ' <img src="'.get_bloginfo('template_url').'/images/qq_32x32.png" > QQ ';	
		}else{
			$type = 'weibo';
			$name = ' <img src="'.get_bloginfo('template_url').'/images/weibo_32x32.png" > 微博 ';	
		}
		
				if( isset($_GET['wpnonce']) && wp_verify_nonce( trim($_GET['wpnonce']), $type.'_logout' ) ){

					$user_ID = get_current_user_id();

					if($type==='weibo'){
						$token = get_user_meta($user_ID , 'dmeng_weibo_access_token', true );
						$info = wp_remote_retrieve_body(wp_remote_get('https://api.weibo.com/oauth2/revokeoauth2?access_token='.$token));	
					}

					delete_user_meta($user_ID, 'dmeng_'.$type.'_openid');
					delete_user_meta($user_ID, 'dmeng_'.$type.'_access_token');
					
					header('Location:'.$redirect);
					exit;
				
				}else{
					
					wp_die(
						sprintf( __('你正在试图解除%1$s绑定，确定这样做吗？<a href="%2$s">点击继续</a> <p>不知道这是哪里？<a href="%3$s">点击返回</a></p>','momo'), $name, add_query_arg( 'wpnonce', wp_create_nonce( $type.'_logout' ), dmeng_get_current_page_url() ), $redirect ),
						__('解除账号绑定','momo') , array( 'response'=>503 )
					);
					
				}
				
	}
	
	function dmeng_set_redirect_cookie(){
		setcookie('dmeng_logged_in_redirect', urlencode(dmeng_get_redirect_uri()), time()+3600);
	}
	
	function dmeng_get_redirect_text(){
		$redirect = isset($_COOKIE['dmeng_logged_in_redirect']) ? urldecode($_COOKIE['dmeng_logged_in_redirect']) : dmeng_get_redirect_uri();
		return '<a href="'.$redirect.'">点击返回</a>';
	}
	
	function dmeng_connect_check($str=''){
		if(empty($str)){
			wp_die(__('服务器无法连接开放平台，请重试或联系管理员！', 'momo').dmeng_get_redirect_text(), __('无法连接开发平台', 'momo'), array( 'response'=>503 ));
		}
		return $str;
	}

	if( isset($_GET['connect']) && trim($_GET['connect'])==='qq' && dmeng_is_open_qq() && ( is_home() ||is_front_page() ) ){

		dmeng_set_redirect_cookie();

		global $OPEN_QQ;
		
		if( isset($_GET['action']) ){
			
			if( trim($_GET['action'])==='login' && wp_verify_nonce( $_GET['_wpnonce'], 'check-open' ) ){
				
					if( is_user_logged_in() && get_user_meta( $user_ID, 'dmeng_qq_openid', TRUE ) ){
						wp_die('你已经绑定了QQ号，一个账号只能绑定一个QQ号，如要更换，请先解绑现有QQ账号，再绑定新的。<p><a href="'.$redirect.'">点击返回</a></p>','不能绑定多个QQ', array( 'response'=>503 ));
					}

					$state = md5(uniqid(rand(), true));
				
				$params = array(
					'response_type'=>'code',
					'client_id'=>$OPEN_QQ['APPID'],
					'state'=>$state,
					'scope'=>'get_user_info,get_info,add_t,del_t,add_pic_t,get_repost_list,get_other_info,get_fanslist,get_idollist,add_idol,del_idol',
					'redirect_uri'=>$OPEN_QQ['CALLBACK']
				);
				
				setcookie('qq_state', md5($state), time()+600);
				
				header('Location:https://graph.qq.com/oauth2.0/authorize?'.http_build_query($params));
				exit();
			}
			
			if(trim($_GET['action'])==='logout' && wp_verify_nonce( $_GET['_wpnonce'], 'check-open-logout' ) && is_user_logged_in()) dmeng_open_logout('qq');
			
		}



		if( isset($_GET['code']) && isset($_GET['state']) && isset($_COOKIE['qq_state']) && $_COOKIE['qq_state']==md5($_GET['state']) ){
			
			$params = array(
				'grant_type'=>'authorization_code',
				'code'=>$_GET['code'],
				'client_id'=>$OPEN_QQ['APPID'],
				'client_secret'=>$OPEN_QQ['APPKEY'],
				'redirect_uri'=>$OPEN_QQ['CALLBACK']
			);

			$response = dmeng_connect_check(wp_remote_retrieve_body(wp_remote_get('https://graph.qq.com/oauth2.0/token?'.http_build_query($params))));

			 if (strpos($response, "callback") !== false){
				$lpos = strpos($response, "(");
				$rpos = strrpos($response, ")");
				$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
				$msg = json_decode($response);
				if (isset($msg->error)){
					wp_die( "<b>error</b> " . $msg->error . " <b>msg</b> " . $msg->error_description.$redirect_text , $die_title , array( 'response'=>503 ) );
				}
			 }
			 
			$params = array();
			parse_str($response, $params);
			$token = $params['access_token'];
			
			$graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$token;
			
			$str = dmeng_connect_check(wp_remote_retrieve_body(wp_remote_get($graph_url)));
	 
			if (strpos($str, "callback") !== false){
				$lpos = strpos($str, "(");
				$rpos = strrpos($str, ")");
				$str  = substr($str, $lpos + 1, $rpos - $lpos -1);
			}
			$user = json_decode($str);
			if (isset($user->error)){
				wp_die( "<b>error</b> " . $user->error . " <b>msg</b> " . $user->error_description.$redirect_text , $die_title , array( 'response'=>503 ) );
			}

			$qq_openid = $user->openid;
			
			$info_url = "https://graph.qq.com/user/get_user_info?access_token=".$token."&oauth_consumer_key=".$OPEN_QQ['APPID']."&openid=".$qq_openid;
			
			$info = json_decode(dmeng_connect_check(wp_remote_retrieve_body(wp_remote_get($info_url))));
			
			if ($info->ret){
				wp_die( "<b>error</b> " . $info->ret . " <b>msg</b> " . $info->msg.$redirect_text , $die_title , array( 'response'=>503 ) );
			}

			dmeng_open_login($qq_openid,$token,'qq',$info->nickname);

			exit;
		}
	
	}

	if( isset($_GET['connect']) && trim($_GET['connect'])==='weibo' && dmeng_is_open_weibo() && ( is_home() ||is_front_page() ) ){
		
		dmeng_set_redirect_cookie();
		
		global $OPEN_WEIBO;
		
		if( isset($_GET['action']) ){
			
			if(trim($_GET['action'])==='login' && wp_verify_nonce( $_GET['_wpnonce'], 'check-open' ) ){
				if( is_user_logged_in() && get_user_meta( $user_ID, 'dmeng_weibo_openid', TRUE ) ){
					wp_die('你已经绑定了微博账号，一个账号只能绑定一个微博，如要更换，请先解绑现有微博账号，再绑定新的。<p><a href="'.$redirect.'">点击返回</a></p>','不能绑定多个微博', array( 'response'=>503 ));
				}
				$params = array(
					'response_type'=>'code',
					'client_id'=>$OPEN_WEIBO['KEY'],
					'redirect_uri'=>$OPEN_WEIBO['CALLBACK']
				);
				header('Location:https://api.weibo.com/oauth2/authorize?'.http_build_query($params));
				exit();
			}
			
			if(trim($_GET['action'])==='logout' && wp_verify_nonce( $_GET['_wpnonce'], 'check-open-logout' ) && is_user_logged_in()) dmeng_open_logout('weibo');

		}

		if( isset($_GET['code']) ){

			$access = dmeng_connect_check(wp_remote_retrieve_body(wp_remote_post('https://api.weibo.com/oauth2/access_token?', array( 'body' => array(
				'grant_type'=>'authorization_code',
				'client_id'=>$OPEN_WEIBO['KEY'],
				'client_secret'=>$OPEN_WEIBO['SECRET'],
				'code'=>trim($_GET['code']),
				'redirect_uri'=>$OPEN_WEIBO['CALLBACK']
			)) )));
			
			$access = json_decode($access,true);
			
			if (isset($access["error"])){
				wp_die( "<b>error</b> " . $access["error"] . " <b>msg</b> " . $access["error_description"].$redirect_text , $die_title , array( 'response'=>503 ) );
			}
	
			$openid = $access["uid"];
			$token = $access["access_token"];

			$info = dmeng_connect_check(wp_remote_retrieve_body(wp_remote_get('https://api.weibo.com/2/users/show.json?access_token='.$token.'&uid='.$openid)));

			$info = json_decode($info,true);
			
			if (isset($info["error"])){
				wp_die( "<b>error</b> " . $info["error_code"] . " <b>msg</b> " . $info["error"].$redirect_text , $die_title , array( 'response'=>503 ) );
			}
			
			dmeng_open_login($openid,$token,'weibo',$info["name"]);
			
			exit();
		}

	}
}
add_action('template_redirect', 'dmeng_open_template_redirect' );
