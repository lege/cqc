<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta name="baidu-tc-verification" content="0fb041a64ee71333c957d8c784961cc8" />
<meta property="qc:admins" content="145637425211673116375" />
<meta http-equiv="X-UA-Compatible" content="IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php wp_title('-', true, 'right'); echo get_option('blogname'); if (is_home ()) echo get_option('blogdescription'); if ($paged > 1) echo '-Page ', $paged; ?></title>
<?php
$sr_1 = 0; $sr_2 = 0; $commenton = 0; 
if( dopt('d_sideroll_b') ){ 
    $sr_1 = dopt('d_sideroll_1');
    $sr_2 = dopt('d_sideroll_2');
}
if( is_singular() ){ 
    if( comments_open() ) $commenton = 1;
}
?>
<script>
window._deel = {name: '<?php bloginfo('name') ?>',url: '<?php echo get_bloginfo("template_url") ?>', ajaxpager: '<?php echo dopt('d_ajaxpager_b') ?>', commenton: <?php echo $commenton ?>, roll: [<?php echo $sr_1 ?>,<?php echo $sr_2 ?>]}
</script>
<?php 
wp_head(); 
if( dopt('d_headcode_b') ) echo dopt('d_headcode'); ?>
<!--[if lt IE 9]><script src="<?php bloginfo('template_url'); ?>/js/html5.js"></script><![endif]-->

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?3ef185224776ec2561c9f7066ead4f24";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<meta name="360-site-verification" content="bdc579accc68a98f1258ebcce2266afa" />
<script type="text/javascript" name="baidu-tc-cerfication" data-appid="5411405" src="http://apps.bdimg.com/cloudaapi/lightapp.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo home_url() ?>/fav.png" />
<script type="text/javascript">
$(document).ready(function(){
	var imgs = new Array();
	imgs[0] = 'http://qiniu.cuiqingcai.com/wp-content/uploads/2015/05/20150525111154.jpg';
	imgs[1] = 'http://qiniu.cuiqingcai.com/wp-content/uploads/2015/05/20150525111447.jpg';
	imgs[2] = 'http://qiniu.cuiqingcai.com/wp-content/uploads/2015/05/20150525112058.jpg';
	imgs[3] = 'http://qiniu.cuiqingcai.com/wp-content/uploads/2015/05/20150525112112.jpg';
	imgs[4] = 'http://qiniu.cuiqingcai.com/wp-content/uploads/2015/05/20150525112129.jpg';
	imgs[5] = 'http://qiniu.cuiqingcai.com/wp-content/uploads/2015/05/20150525112155.jpg';
	$('.ds-avatar img[src*="cdncache"]').each(function(){
		var rand = Math.floor(Math.random()*imgs.length);
		$(this).attr("src",imgs[rand]);
	})
});
</script>
</head>
<body <?php body_class(); ?>>

<header id="header" class="header">
<div class="container-inner">
 <div class="yusi-logo">
                    <a href="/">
                        <h1>
                                                        <span class="yusi-mono"><?php bloginfo('name'); ?></span>
                                                        <span class="yusi-bloger"><?php bloginfo('description'); ?></span>
                                                    </h1>
                    </a>
    </div>
</div>

	<div id="nav-header" class="navbar">
		
		<ul class="nav">
			<?php echo str_replace("</ul></div>", "", ereg_replace("<div[^>]*><ul[^>]*>", "", wp_nav_menu(array('theme_location' => 'nav', 'echo' => false)) )); ?>
<li style="float:right;">
                    <div class="toggle-search"><i class="fa fa-search"></i></div>
<div class="search-expand" style="display: none;"><div class="search-expand-inner"><form method="get" class="searchform themeform" onsubmit="location.href='<?php echo home_url('/?s='); ?>' + encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;" action="/"><div> <input type="ext" class="search" name="s" onblur="if(this.value=='')this.value='search...';" onfocus="if(this.value=='search...')this.value='';" value="search..."></div></form></div></div>
</li>
		</ul>
	</div>
	</div>
</header>
<section class="container"><div class="speedbar">
		<?php 
		if( dopt('d_sign_b') ){ 
			global $current_user; 
			get_currentuserinfo();
			$uid = $current_user->ID;
			$u_name = get_user_meta($uid,'nickname',true);
		?>
			<div class="pull-right">
				<?php if(is_user_logged_in()){ echo '<i class="fa fa-user"></i> <a href="/wp-admin">'.$u_name.'</a>&nbsp;&nbsp&nbsp';   }else{  echo '<i class="fa fa-user"></i> <a href="/wp-login.php?action=register">投稿</a>&nbsp;&nbsp;&nbsp;';   };  echo '   <i class="fa fa-power-off"></i> ';echo wp_loginout();echo'';  ?>
			</div>
		<?php } ?>
		<div class="toptip"><strong class="text-success"><i class="fa fa-volume-up"></i> </strong> <?php echo dopt('d_tui'); ?></div>
	</div>
	<?php if( dopt('d_adsite_01_b') ) echo '<div class="banner banner-site">'.dopt('d_adsite_01').'</div>'; ?>