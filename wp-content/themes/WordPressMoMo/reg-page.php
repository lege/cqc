<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言 */
if( !empty($_POST['ludou_reg']) ) {
  $error = '';
  $sanitized_user_login = sanitize_user( $_POST['user_login'] );
  $user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );
  // Check the username
  if ( $sanitized_user_login == '' ) {
    $error .= '<strong>错误</strong>：请输入用户名。<br />';
  } elseif ( ! validate_username( $sanitized_user_login ) ) {
    $error .= '<strong>错误</strong>：此用户名包含无效字符，请输入有效的用户名<br />。';
    $sanitized_user_login = '';
  } elseif ( username_exists( $sanitized_user_login ) ) {
    $error .= '<strong>错误</strong>：该用户名已被注册，请再选择一个。<br />';
  }
  // Check the e-mail address

  if ( $user_email == '' ) {
    $error .= '<strong>错误</strong>：请填写电子邮件地址。<br />';
  } elseif ( ! is_email( $user_email ) ) {

    $error .= '<strong>错误</strong>：电子邮件地址不正确。！<br />';
    $user_email = '';

  } elseif ( email_exists( $user_email ) ) {
    $error .= '<strong>错误</strong>：该电子邮件地址已经被注册，请换一个。<br />';
  }
  // Check the password

  if(strlen($_POST['user_pass']) < 6)

    $error .= '<strong>错误</strong>：密码长度至少6位!<br />';

  elseif($_POST['user_pass'] != $_POST['user_pass2'])
    $error .= '<strong>错误</strong>：两次输入的密码必须一致!<br />';

     

    if($error == '') {

    $user_id = wp_create_user( $sanitized_user_login, $_POST['user_pass'], $user_email );

   

    if ( ! $user_id ) {

      $error .= sprintf( '<strong>错误</strong>：无法完成您的注册请求... 请联系<a href=\"mailto:%s\">管理员</a>！<br />', get_option( 'admin_email' ) );

    }

    else if (!is_user_logged_in()) {

      $user = get_userdatabylogin($sanitized_user_login);

      $user_id = $user->ID;

 

      // 自动登录
      wp_set_current_user($user_id, $user_login);
      wp_set_auth_cookie($user_id);
      do_action('wp_login', $user_login,$user_id);

    }

  }

}

	



get_header(); ?>

<?php get_header('masthead'); ?>



<div id="main" class="container" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">



	<div class="row">

				

		<article id="content" class="col-lg-12 col-md-8 single" data-post-id="<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/Article">

	

			<div class="panel panel-default">

				<div class="entry-breadcrumb clearfix" role="toolbar"><span class="glyphicon glyphicon-home" style="margin-right:8px"></span><?php wpmomo_breadcrumb_html(get_the_ID(),'&nbsp› &nbsp'); ?></div>

				

				<div class="panel-body" style="padding-bottom:100px;">

					

						<div class="col-lg-8 col-md-6 col-sm-12" style="margin:0 auto;float:none;"  itemprop="articleBody" data-no-instant>

					

						<div class="col-lg-6 col-md-6 col-sm-12">
							<div style="width:90%">
								<div class="ludou-login" style="text-align:center;font-size:28px;font-weight:bold;margin: 50px auto 10px;">注册</div>
									<?php the_content(); ?>
									<?php if(!empty($error)) {
										echo '<p class="ludou-error">'.$error.'</p>';
									}
if (!is_user_logged_in()) { ?>
<form name="registerform" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="ludou-reg">
    <p>
        <input type="text" name="user_login" tabindex="1" id="user_login" class="input" value="<?php if(!empty($sanitized_user_login)) echo $sanitized_user_login; ?>" placeholder="<?php _e('用户名 &hellip;','momo');?>"/>
    </p>
    <p>
        <input type="text" name="user_email" tabindex="2" id="user_email" class="input" value="<?php if(!empty($user_email)) echo $user_email; ?>" placeholder="<?php _e('电子邮件 &hellip;','momo');?>"/>
    </p>
    <p>
        <input id="user_pwd1" class="input" tabindex="3" type="password" tabindex="21"  value="" name="user_pass" placeholder="<?php _e('密码(至少6位) &hellip;','momo');?>"/>
    </p>
    <p>
        <input id="user_pwd2" class="input" tabindex="4" type="password" tabindex="21"  value="" name="user_pass2"  placeholder="<?php _e('重复密码 &hellip;','momo');?>"/>
    </p>

	<p class="login-submit">
	<input type="hidden" name="ludou_reg" value="ok" />
	<input name="wp-submit" id="wp-submit" class="button-primary" value="注册" type="submit" style="">
	</p>
</form>
<?php } else {
 echo '<p class="ludou-error">您已注册成功，并已登录！</p>';
} ?>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12" >
							<div style="margin-top: 130px;">
							<div style="margin:15px auto;font-size:13px;width:200px;">无需注册，使用新浪微博账号登录</div>
							<div class="loginweibo">新浪微博账号登录</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		 </article><!-- #content -->		
	</div>
 </div><!-- #main -->
<?php get_footer('colophon'); ?>
<?php get_footer(); ?>