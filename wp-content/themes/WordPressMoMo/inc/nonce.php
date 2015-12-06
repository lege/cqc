<?php/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦 */

/*
 * 安全验证码 nonce @author 
 * 
 */

//~ 通过AJAX获取并保存到cookie是防止页面进行缓存加速后nonce不能及时更新
function dmeng_create_nonce_callback(){

	echo wp_create_nonce( 'check-nonce' );

   die();
}
add_action( 'wp_ajax_dmeng_create_nonce', 'dmeng_create_nonce_callback' );
add_action( 'wp_ajax_nopriv_dmeng_create_nonce', 'dmeng_create_nonce_callback' );
