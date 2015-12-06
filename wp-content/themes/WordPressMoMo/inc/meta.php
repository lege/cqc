<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦 */

/*
 * 自定义meta 
 * 主要用于投票
 * 
 */
 
/*
 * 添加数据库表 
 * 
 * meta_id 自动增长主键
 * user_id 用户ID
 * meta_key 唯一身份
 * meta_value 值
 * 
 */

function dmeng_meta_install_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'dmeng_meta';   
    if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) :   
		$sql = " CREATE TABLE `$table_name` (
			`meta_id` int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(meta_id),
			`user_id` int,
			`meta_key` tinytext,
			`meta_value` tinytext
		) CHARSET=utf8;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');   
			dbDelta($sql);   
    endif;
}
function dmeng_meta_install(){
    global $pagenow;   
    if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        dmeng_meta_install_callback();
}
add_action( 'load-themes.php', 'dmeng_meta_install' );   

/*
 * 
 * 获取meta数
 * 
 */

function get_dmeng_meta_count( $key, $value=0, $uid='all' ){

	if( !$key ) return;

	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	if($uid!=='all') $uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';

	$sql = "SELECT count(meta_id) FROM $table_name WHERE meta_key='$key'";
	if($value) $sql .= " AND meta_value='$value'";
	if(is_int($uid)) $sql .= " AND user_id='$uid'";

	$check = $wpdb->get_var($sql);

	if(isset($check)){
	
		return $check;
			
	}else{

		return 0;
			
	}
}

function get_dmeng_meta( $key , $uid=0 ){

	if( !$key ) return;

	$key = sanitize_text_field($key);
	$uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';
	
	$check = $wpdb->get_var( "SELECT meta_value FROM $table_name WHERE meta_key='$key' AND user_id='$uid'" );

	return isset($check) ? $check : 0;
}

function get_dmeng_metas( $key , $uid=0, $limit=0, $offset=0 ){

	if( !$key ) return;

	$key = sanitize_text_field($key);
	$uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';
	
	$sql = "SELECT user_id, meta_value FROM $table_name WHERE meta_key='$key'";
	if($uid) $sql .= " AND user_id='$uid'";
	
	$sql .= " ORDER BY meta_id DESC";
	
	if($limit) $sql .= " LIMIT $offset,$limit";
	
	$check = $wpdb->get_results( $sql );

	return isset($check) ? $check : 0;
}

function dmeng_meta_exists($uid, $key, $value){
	
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';
	
	$check = $wpdb->get_var( "SELECT meta_id FROM $table_name WHERE user_id='$uid' AND meta_key='$key' AND meta_value='$value'" );

	return isset($check) ? $check : 0;

}


/*
 * 
 * 添加meta
 * 
 */

function add_dmeng_meta( $key, $value, $uid=0 ){

	if( !$key || !$value ) return;

	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = sanitize_text_field($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';

	if($wpdb->query( "INSERT INTO $table_name (user_id,meta_key,meta_value) VALUES ('$uid', '$key', '$value')" ))
		return 1;
	
	return 0;
}

/*
 * 
 * 更新meta
 * 
 */

function update_dmeng_meta( $key, $value, $uid=0 ){

	if( !$key || !$value ) return;

	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	$uid = sanitize_text_field($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';
	
	$check = $wpdb->get_var( "SELECT meta_id FROM $table_name WHERE user_id='$uid' AND meta_key='$key'" );

	if(isset($check)){
	
		if($wpdb->query( "UPDATE $table_name SET meta_value='$value' WHERE meta_id='$check'" ))
			return $check;

	}else{
	
		if($wpdb->query( "INSERT INTO $table_name (user_id,meta_key,meta_value) VALUES ('$uid', '$key', '$value')" ))
			return 'inserted';
			
	}
	
	return 0;
}


/*
 * 
 * 删除meta
 * 
 */

function delete_dmeng_meta( $key, $value=0, $uid='all' ){

	if( !$key ) return;
	
	$key = sanitize_text_field($key);
	$value = sanitize_text_field($value);
	if($uid!=='all') $uid = intval($uid);
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'dmeng_meta';

	$where = " WHERE meta_key='$key'";
	if($value) $where .= " AND meta_value='$value'";
	if(is_int($uid)) $where .= " AND user_id='$uid'";
	
    if ( $wpdb->get_var( "SELECT meta_id FROM $table_name".$where ) ) {
        return $wpdb->query( "DELETE FROM $table_name".$where );
    }
    
    return false;
}
