<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦 */

/*
 * 最近登录 
 * 
 */

function dmeng_update_latest_login( $user_login, $user ){
	update_user_meta( $user->ID, 'dmeng_latest_login', current_time( 'mysql' ) );
}
add_action( 'wp_login', 'dmeng_update_latest_login', 20, 2 );
 
function dmeng_latest_login_column( $columns ) {
	$columns['dmeng_latest_login'] = '上次登录';
	return $columns;
}
add_filter( 'manage_users_columns', 'dmeng_latest_login_column' );
 
function dmeng_latest_login_column_callback( $value, $column_name, $user_id ) {
	if('dmeng_latest_login' == $column_name){
		$user = get_user_by( 'id', $user_id );
		$value = ( $user->dmeng_latest_login ) ? $user->dmeng_latest_login : $value = __('没有记录','momo');
	}
	return $value;
}
add_action( 'manage_users_custom_column', 'dmeng_latest_login_column_callback', 10, 3 );

function dmeng_get_recent_user($number=10){
	$user_query = new WP_User_Query( array ( 'orderby' => 'meta_value', 'order' => 'DESC', 'meta_key' => 'dmeng_latest_login', 'number' => $number ) );
	if($user_query) return $user_query->results;
	return;
}
