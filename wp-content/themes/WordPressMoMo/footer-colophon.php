<?php
/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦
 */
 ?>

<footer id="colophon" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
	<div class="container">
	<div class="row">
	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
	<?

	// 底部菜单1
$menu_name = 'footmenu1';
$locations = get_nav_menu_locations();
$menu_id = $locations[ $menu_name ] ;
$menu_obj = wp_get_nav_menu_object($menu_id);

echo '<div class="eachfmenu"><h2>'.$menu_obj-> name.'</h2>';
				if ( has_nav_menu( 'footmenu1' ) ) {
					wp_nav_menu( array(
						'theme_location'    => 'footmenu1',
						'container_class' => 'footer-menu-container',
						'menu_class'      => 'footer-menu',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)	);

				}else{ echo '未设置底部菜单，请前往后台"外观"->"菜单"，设置"底部菜单"</a> ';}
echo '</div>';

	?>		
	<?

	// 底部菜单2
$menu_name = 'footmenu2';
$locations = get_nav_menu_locations();
$menu_id = $locations[ $menu_name ] ;
$menu_obj = wp_get_nav_menu_object($menu_id);

echo '<div class="eachfmenu"><h2>'.$menu_obj-> name.'</h2>';
				if ( has_nav_menu( 'footmenu2' ) ) {
					wp_nav_menu( array(
						'theme_location'    => 'footmenu2',
						'container_class' => 'footer-menu-container',
						'menu_class'      => 'footer-menu',
					)	);
				}
echo '</div>';
	?>
	<?
	// 底部菜单3
$menu_name = 'footmenu3';
$locations = get_nav_menu_locations();
$menu_id = $locations[ $menu_name ] ;
$menu_obj = wp_get_nav_menu_object($menu_id);
echo '<div class="eachfmenu"><h2>'.$menu_obj-> name.'</h2>';
				if ( has_nav_menu( 'footmenu3' ) ) {
					wp_nav_menu( array(
						'theme_location'    => 'footmenu3',
						'container_class' => 'footer-menu-container',
						'menu_class'      => 'footer-menu',						
					)	);
				}
echo '</div>';
	?>	
	<?
	// 底部菜单4
$menu_name = 'footmenu4';

$locations = get_nav_menu_locations();

$menu_id = $locations[ $menu_name ] ;

$menu_obj = wp_get_nav_menu_object($menu_id);

echo '<div class="eachfmenu"><h2>'.$menu_obj-> name.'</h2>';
				if ( has_nav_menu( 'footmenu4' ) ) {
					wp_nav_menu( array(
						'theme_location'    => 'footmenu4',
						'container_class' => 'footer-menu-container',
						'menu_class'      => 'footer-menu',
					)	);					
				}
echo '</div>';
	?>	
	</div>

	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

<div class="copyright">

<?php
			$output = sprintf('&copy; %s copyright <a href="%s">%s</a> ',date( 'Y', current_time( 'timestamp', 0 ) ),home_url('/'),get_bloginfo('name') );
			$output .= '<br>';
			$output .=__('All Rights Reserved. ','momo').'  <a href="http://www.miitbeian.gov.cn/">'.get_option('zh_cn_l10n_icp_num', '').'</a>'.' '.stripslashes(htmlspecialchars_decode($GLOBALS['dmeng_general_setting']['footer_code']));
			echo $output;
?>			
			<div style="margin-top:20px;">WordPress主题源自 <a href="http://www.wpmomo.com/">wpmomo</a></div>
</div>
	</div>
	</div>
	</div>
</footer>