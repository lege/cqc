<?php

/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦
 */
$url_this='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];

$header_content = '';

$custom_header = wpmomo_custom_header();

if( $custom_header ){

	$profile_li = '';

	$current_user = wp_get_current_user();

	if( $current_user->exists() ){

		$author_url = get_edit_profile_url($current_user->ID);

		$avatar_url = dmeng_get_avatar( $current_user->ID , '40' , dmeng_get_avatar_type($current_user->ID), true );

		$profile_li .= '<div class="l_x"><a href="'.get_edit_profile_url($current_user->ID).'">'.$avatar_url.'</a><div class="l_l_l phnosee">欢迎'.$current_user->display_name.' 回来<br> <span class="phnosee">进入我的 </span><a href="'.get_edit_profile_url($current_user->ID).'">[ 个人中心 ]</a> | <a href="'.wp_logout_url( $url_this).'"  data-no-instant>[ 退出 ]</a></div></div>';

	}else{

		$profile_li .= '<div class="unload"><a data-toggle="modal" data-target="#myModal" style="cursor:pointer">登录</a>|  <a href="'.get_option('home').'/register">  注册  </a></div>';

	}

	$email_tips = '';

	if( ! is_email($current_user->user_email) ){

		$email_tips =  'data-toggle="tooltip" title="'.__('请添加正确的邮箱以保证账户安全','momo').'"';

		$author_url .= '#pass';

	}

	if( $current_user->user_email != $current_user->dmeng_verify_email ){

		$email_tips =  'data-toggle="tooltip" title="'.__('请验证一个邮箱用以接收通知','momo').'"';

		$author_url .= '#pass';

	}

	$avatar_html = $avatar_url ? sprintf('<a href="%s" class="thumbnail avatar"%s>%s</a>', $author_url, $email_tips, $avatar_url) : '';


	$profile_html = '<ul class="user-profile">'.$profile_li.'</ul>';

	$header_content = '<div id="top"><div class="container header-content"><div class="row">';

	$header_content .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">'.$custom_header.'</div>';

	$header_content .= '<div class="col-lg-4 col-md-4 col-sm-4">'.get_search_form($true).'</div>';

	$header_content .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'. $profile_li.'</div>';

	$header_content .= '</div></div></div>';

}


 ?>

 <script>
 jQuery(document).ready(function(){
jQuery('#myModal').modal('hide')

})
</script>



<?php
	$permalink = get_option('home')."/login";
 ?>

<!-- 模态框（Modal） -->



<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" style="width:300px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">登录</h4>
			</div>
			<div class="modal-body">
				<form name="loginform" id="loginform" action="<?php echo $permalink ?>" method="post">
				<p class="login-username">
				<input name="log" id="user_login" class="input" value="" size="20" type="text" placeholder="用户名">
				</p>

				<p class="login-password">
				<input name="pwd" id="user_pass" class="input" value="" size="20" type="password" placeholder="密码">
				</p>
				<p class="login-remember"><label><input name="rememberme" id="rememberme" value="forever" type="checkbox"> 记住我的登录信息</label></p>
				<p class="login-submit">
				<input name="wp-submit" id="wp-submit" class="button-primary" value="登录" type="submit">
				</p>
				</form>
			</div>
			<?php 			$weibo_open = intval(get_option('dmeng_open_weibo',1));			if ($weibo_open) :			?>
			<div class="modal-footer">
				<a href="<?php echo  dmeng_get_open_login_url('weibo', 'login', dmeng_get_current_page_url()); ?>"><div class="loginweibo">新浪微博账号登录</div></a>
			</div>			<?php endif; ?>

			

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->







<header id="masthead" itemscope itemtype="http://schema.org/WPHeader">

	<?php echo $header_content;?>

	<nav class="navbar navbar-default theme-color" role="banner">
		<div class="container">
		<div class="row">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar"><span class="sr-only"><?php _e('切换菜单','momo');?></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<?php
				$brand_class[] = 'navbar-brand';				
				if(!$custom_header){
					$brand_class[] = 'show';
				}
				$blogname = get_option('blogname');
				$blogname =  ( is_home() || is_front_page() ) ? '<h1>'.$blogname.'</h1>' : $blogname;
				printf('<a class="%1$s" href="%2$s" rel="home" itemprop="headline">%3$s</a>', join(' ', $brand_class), esc_url(home_url('/')), $blogname);
				?>
			</div>
			<div id="navbar" class="collapse navbar-collapse" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php

				// 载入菜单

				//  wp_bootstrap_navwalker 是 /inc/wp_bootstrap_navwalker.php 的类，已在functions.php载入
				// 主菜单
				if ( has_nav_menu( 'header_menu' ) ) {
					wp_nav_menu( array(
						'menu'              => 'header_menu',
						'theme_location'    => 'header_menu',
						'depth'             => 0,
						'container'         => '',
						'container_class'   => '',
						'menu_class'        => 'nav navbar-nav',
						'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'walker'            => new WPMoMo_Bootstrap_Menu()
					)	);
				}else{					echo '<div class="setmenu"><a href="'.home_url('/').'wp-admin/nav-menus.php">请前往后台"外观"->"菜单"，设置"头部菜单"</a></div>';				}



				// 右侧菜单

				if ( has_nav_menu( 'header_right_menu' ) ) {

					wp_nav_menu( array(

						'menu'              => 'header_right_menu',

						'theme_location'    => 'header_right_menu',

						'depth'             => 0,

						'container'         => '',

						'container_class'   => '',

						'menu_class'        => 'nav navbar-nav navbar-right',

						'items_wrap' 		=> '<ul class="%2$s">%3$s</ul>',

						'walker'            => new WPMoMo_Bootstrap_Menu()

					)	);

				}

				
			

			?>

<form class="navbar-form input-group input-group-sm" role="search" method="get" id="searchform1" action="<?php echo home_url( '/' ); ?>">
	
	<input type="text" class="form-control form-control1" placeholder="<?php _e('搜索 &hellip;','momo');?>" name="s" id="s" required>
	
	<span class="input-group-btn">
		<button type="submit" class="btn btn-default btn-default1" id="searchsubmit">
			<span class="glyphicon glyphicon-search"></span>
		</button>
	</span>

</form>


			

		</div>

			</div><!-- #navbar -->

		</div>

	</nav>



</header><!-- #masthead -->