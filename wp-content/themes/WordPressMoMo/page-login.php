<?php

/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */

if (!isset($_SESSION)){
  session_start();             //创建一个session会话
  session_regenerate_id();
}
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''&& strpos($_SERVER['HTTP_REFERER'],'admin') == false&& strpos($_SERVER['HTTP_REFERER'],'login') == false){
	// 登陆前的页面地址
	// 如果你想登陆后返回首页，请将 $_SERVER['HTTP_REFERER'] 改成 'http://你的首页网址'
	$_SESSION["REFERER"] = $_SERVER['HTTP_REFERER'];
}  

$url_this='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$error = '';$secure_cookie = false;$user_name = sanitize_user( $_POST['log'] );$user_password = $_POST['pwd'];if ( empty($user_name) || ! validate_username( $user_name ) ) {	$error .= '<strong>错误</strong>：请输入有效的用户名。<br />';	$user_name = '';}
if( empty($user_password) ) {	$error .= '<strong>错误</strong>：请输入密码。<br />';}
if($error == '') {
	// If the user wants ssl but the session is not ssl, force a secure cookie.
    if ( !empty($user_name) && !force_ssl_admin() ) {
		if ( $user = get_user_by('login', $user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
			$secure_cookie = true;
			force_ssl_admin(true);
        }	}	}
	if ( isset( $_GET['r'] ) ) {		$redirect_to = $_GET['r'];		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	}else {		$redirect_to =  $_SESSION["REFERER"];	}
		if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;
		$creds = array();
		$creds['user_login'] = $user_name;
		$creds['user_password'] = $user_password;
		$creds['remember'] = !empty( $_POST['rememberme'] );
		$user = wp_signon( $creds, $secure_cookie );
		if ( is_wp_error($user) ) {
			$error .= $user->get_error_message();
		}else {
		unset($_SESSION['ludou_token']);
		wp_safe_redirect($redirect_to);
		}
}
unset($_SESSION['ludou_token']);

$rememberme = !empty( $_POST['rememberme'] );
$token = md5(uniqid(rand(), true));
$_SESSION['ludou_token'] = $token;
get_header(); ?>

<?php get_header('masthead'); ?>

<div id="main" class="container" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

<div class="row">

		<article id="content" class="col-lg-12 col-md-8 single" data-post-id="<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/Article">

			<div class="panel panel-default">
				<div class="entry-breadcrumb clearfix" role="toolbar"><span class="glyphicon glyphicon-home" style="margin-right:8px"></span><?php wpmomo_breadcrumb_html(get_the_ID(),'&nbsp› &nbsp'); ?></div>
				<div class="panel-body" style="padding-bottom:100px;">

					<div class="col-lg-8 col-md-6 col-sm-12" style="margin:0 auto;float:none;"  itemprop="articleBody" data-no-instant>
						<div class="col-lg-6">
							<div style="width:90%">
								<div class="ludou-login" style="text-align:center;font-size:28px;font-weight:bold;margin: 50px auto 10px;">登录</div>

									<?php if(!empty($error)) {
									echo '<p class="ludou-error">'.$error.'</p>';
									}

									if (!is_user_logged_in()) { ?>

									<form name="loginform" method="post" class="ludou-login" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" >
									<p><input type="text" name="log" id="log" class="input" value="<?php if(!empty($user_name)) echo $user_name; ?>" placeholder="<?php _e('用户名 &hellip;','momo');?>" /></p>

									<p><input id="pwd" class="input" type="password" value="" name="pwd" placeholder="<?php _e('密码 &hellip;','momo');?>"/></p>

									<p class="forgetmenot" style="margin-top:25px;margin-bottom:33px;">

									<label for="rememberme">

									<input name="rememberme" type="checkbox" id="rememberme" value="1" <?php checked( $rememberme ); ?> />

									记住我

									</label>

									<span style="float:right;"><a href="<?php echo home_url('/wp-login.php?action=lostpassword/'); ?>">忘记密码？</a></span>

									</p>

  

									<p class="login-submit">

									<input type="hidden" name="redirect_to" value="<?php if(isset($_GET['r'])) echo $_GET['r']; ?>" />

									<input type="hidden" name="ludou_token" value="<?php echo $token; ?>" />

									<input name="wp-submit" id="wp-submit" class="button-primary" value="登录" type="submit" style="margin-top:0px!important;">

									</p>

	

									<div style="margin:15px auto;text-align:center;">还没有账号？<a href="<?php echo home_url('/register/'); ?>">注册</div>

									</form>

									<?php } else {

									echo '<p class="ludou-error">您已登录！（<a href="'.wp_logout_url( $url_this).'" title="登出">登出？</a>）</p>';
									} ?>
							</div>
						</div>												<?php 						$weibo_open = intval(get_option('dmeng_open_weibo',1));						if ($weibo_open) :						?>
						<div class="col-lg-6 col-md-6 col-sm-12" >
							<div class="loginpage" style="">
							<div style="margin:15px auto;font-size:13px;width:200px;">无需注册，使用新浪微博账号登录</div>
							<a href="<?php echo  dmeng_get_open_login_url('weibo', 'login', dmeng_get_current_page_url()); ?>"><div class="loginweibo">新浪微博账号登录</div></a>
							</div>
						</div>												<?php endif; ?>
					</div>

					

					

				</div>

			







				

			</div>

			

		 </article><!-- #content -->		

		

		

	

	</div>




 </div><!-- #main -->

<?php get_footer('colophon'); ?>

<?php get_footer(); ?>