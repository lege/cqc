<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8,ie=7">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php wp_title('-', true, 'right'); echo get_option('blogname'); if (is_home ()) echo get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css" media="all">
<!--[if lt IE 9]><script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script><![endif]-->
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie6.css" type="text/css"/> 
<![endif]-->
<!--[if IE 6]>
		<script src="<?php bloginfo('template_url'); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
		<script>DD_belatedPNG.fix('.logo,.widgetzry ul,background,background');</script>
<![endif]-->
<script src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
<?php
$sr_1 = 0; $sr_2 = 0; $commenton = 0; 
if( is_singular() ){ 
    if( dopt('d_sideroll_b') ){ 
        $sr_1 = dopt('d_sideroll_1');
        $sr_2 = dopt('d_sideroll_2');
    }
    if( comments_open() ) $commenton = 1;
}
?>
<script>
window._deel = {
    name: '<?php bloginfo('name') ?>',
    url: '<?php echo get_bloginfo("template_url") ?>',
    rss: '<?php echo dopt('d_rss') ?>',
    maillist: '<?php echo dopt('d_maillist_b') ?>',
    maillistCode: '<?php echo dopt('d_maillist') ?>',
    commenton: <?php echo $commenton ?>,
    roll: [<?php echo $sr_1 ?>,<?php echo $sr_2 ?>]
}
</script>
<?php if( dopt('d_headcode_b') ) echo dopt('d_headcode'); ?>
</head>
<body <?php body_class(); ?>>
<div class="header">
	<div class="navbar">
		<?php if( is_home() ) echo '<h1 class="logo"'.(dopt('d_logo_w')?' style="width:'.dopt('d_logo_w').'px"':'').'><a'; else echo '<a class="logo"'; ?> href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?><?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a><?php if( is_home() ) echo '</h1>'; ?>
		<ul class="nav">
<li class="page_item page-item-8 current_page_item" style=" background: url(/wp-content/themes/Nocower-One/img/current.png) no-repeat center bottom; "><a href="/">首页</a></li>
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
		</ul>
<?php if ( is_user_logged_in() ) { ?><ul class="lozc">
<li style="float: left;margin-right: 15px;"><font style="color:#ffffff">欢迎，</font><?php echo get_avatar( get_current_user_id(), 16 );?>&nbsp;&nbsp;<a class="user_info" href="/wp-admin/profile.php" title="设置个人资料，绑定微博"><?php global $current_user; get_currentuserinfo(); echo $current_user->display_name; ?></a></li>
<li style="float:right;" ><a href="<?php echo wp_logout_url("/"); ?>" title="退出">退出</a></li></ul>
<?php } else { ?><ul class="lozc" >
<li style="float: left;margin-right: 16px;"><a href="<?php echo get_settings('home'); ?>/wp-login.php" target="_blank">登陆</a></li>
<li style="float: right;"><a href="<?php echo get_settings('home'); ?>/wp-login.php?action=register" target="_blank">注册</a></li>
</ul><?php } ?> </div>
	<?php 
		global $current_user; 
		get_currentuserinfo();
		$uid = $current_user->ID;
		$u_name = get_user_meta($uid,'nickname',true);
	?>
</div>
<div class="hed"></div>
<section class="container">
	<?php if( dopt('d_adsite_01_b') ) echo '<div class="banner banner-site">'.dopt('d_adsite_01').'</div>'; ?>