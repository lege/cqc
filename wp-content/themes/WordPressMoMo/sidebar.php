<?php
/* * 亲，如果您喜欢本主题，请上http://www.wpmomo.com发表留言 */
/*
 * 侧边栏
 * 
 */
?>
<div id="sidebar" class="col-lg-4 col-md-4" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
	<?php
			if( is_active_sidebar( 'sidebar-1' ) ){
					dynamic_sidebar( 'sidebar-1' );
			}
	?>
</div><!-- #sidebar -->