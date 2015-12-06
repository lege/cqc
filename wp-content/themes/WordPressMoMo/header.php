<?php



/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦
 */

?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<?php
wp_head();

?>



<meta charset="<?php bloginfo( 'charset' ); ?>" />


<meta name="renderer" content="webkit">



<meta http-equiv="Cache-Control" content="no-siteapp" />



<meta http-equiv="Cache-Control" content="no-transform " /> 



<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >



<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php echo stripslashes(htmlspecialchars_decode(dmeng_setting('head_code')));?>

<!--[if lt IE 8]><script>window.location.href='http://www.wpmomo.com/update-browser.html?referrer='+location.href;</script><![endif]-->



<title><?php wp_title( '&#45;', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="canonical" href="<?php echo dmeng_canonical_url();?>">

<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/jquery.placeholder.min.js'></script>


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

<!--[if lt IE 9]>

  <script src="<?php bloginfo('template_directory'); ?>/js/html5shiv-printshiv.js"></script>

  <script src="<?php bloginfo('template_directory'); ?>/js/respond.js"></script>

<![endif]-->







</head>



<body <?php body_class(); ?> >



