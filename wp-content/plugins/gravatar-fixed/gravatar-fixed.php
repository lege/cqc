<?php
/*
Plugin Name: Gravatar 头像修正
Plugin URI: http://wpceo.com/gravatar-fixed/
Description: 该插件用于修正Gravatar服务器无法正常访问的情况，并且可以自定义Gravatar服务器地址
Author: WPCEO
Author URI: http://wpceo.com/
Version: 1.0
*/

add_action('admin_menu','register_gravatar_admin_menu');
function register_gravatar_admin_menu(){
	add_options_page('Gravatar头像', 'Gravatar头像', 'manage_options', 'gravatar_fixed', 'gravatar_fixed_options');
	add_action( 'admin_init', 'register_gravatar_settings' );
}

function register_gravatar_settings() {
	register_setting( 'gravatar-settings', 'gravatar_server_1' );
	register_setting( 'gravatar-settings', 'gravatar_server_s' );
}

function gravatar_fixed_options(){
?>
<div class="wrap">
<h2>Gravatar 头像修正</h2>
<form method="post" action="options.php">
<?php settings_fields( 'gravatar-settings' ); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Gravatar 服务器</th>
<td><input type="text" name="gravatar_server_1" value="<?php echo get_option('gravatar_server_1'); ?>" class="regular-text" /></td>
</tr> 
<tr valign="top">
<th scope="row">Gravatar SSL 服务器</th>
<td><input type="text" name="gravatar_server_s" value="<?php echo get_option('gravatar_server_s'); ?>" class="regular-text" /></td>
</tr>
</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?php
}

register_activation_hook(__FILE__,'gravatar_fixed_install');
function gravatar_fixed_install() {
	if(!get_option('gravatar_server_1')){
		update_option('gravatar_server_1','http://www.gravatar.com');
	}
	if(!get_option('gravatar_server_s')){
		update_option('gravatar_server_s','https://secure.gravatar.com');
	}
}

// Add settings link on plugin page
function register_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=gravatar_fixed">设置</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_{$plugin}", 'register_plugin_settings_link' );

if ( !function_exists( 'get_avatar' ) ) :
function get_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) {
	if ( ! get_option('show_avatars') )
		return false;

	if ( false === $alt)
		$safe_alt = '';
	else
		$safe_alt = esc_attr( $alt );

	if ( !is_numeric($size) )
		$size = '96';

	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	if ( empty($default) ) {
		$avatar_default = get_option('avatar_default');
		if ( empty($avatar_default) )
			$default = 'mystery';
		else
			$default = $avatar_default;
	}

	if ( !empty($email) )
		$email_hash = md5( strtolower( $email ) );

	if ( is_ssl() ) {
		$host = get_option('gravatar_server_s') ? get_option('gravatar_server_s') : 'https://secure.gravatar.com';
	} else {
		$host = get_option('gravatar_server_1') ? get_option('gravatar_server_1') : 'http://www.gravatar.com';
	}

	if ( 'mystery' == $default )
		$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
	elseif ( 'blank' == $default )
		$default = includes_url('images/blank.gif');
	elseif ( !empty($email) && 'gravatar_default' == $default )
		$default = '';
	elseif ( 'gravatar_default' == $default )
		$default = "$host/avatar/s={$size}";
	elseif ( empty($email) )
		$default = "$host/avatar/?d=$default&amp;s={$size}";
	elseif ( strpos($default, 'http://') === 0 )
		$default = add_query_arg( 's', $size, $default );

	if ( !empty($email) ) {
		$out = "$host/avatar/";
		$out .= $email_hash;
		$out .= '?s='.$size;
		$out .= '&amp;d=' . urlencode( $default );

		$rating = get_option('avatar_rating');
		if ( !empty( $rating ) )
			$out .= "&amp;r={$rating}";

		$avatar = "<img alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
	} else {
		$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
	}

	return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
}
endif;
?>