<?php
/*
如果您对代码有更好的意见，欢迎您上www.wpmomo.com发表您的见解，大家会非常感谢您的！
*/
//~ 头部导航菜单
class WPMoMo_Bootstrap_Menu extends Walker_Nav_Menu  {
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if( $depth == 0 ){
			$output .= '<ul class="dropdown-menu" role="menu">';
		}else{
			$output .= '<ul class="dropdown2">';
		}
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		if( $depth == 0 ){
			$output .= "</ul>";
		}else{
			$output .= '</ul>';
		}
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$caret = $glyphicon_icon = $item_output = '';
		if( $depth > 0 && $item->description ) $item_output .= '<li role="presentation" class="dropdown-header">'.$item->description.'</li><li class="divider"></li>';
		$atts = $atts_class = array();
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['title']   = ! empty( $item->title )        ? esc_attr( $item->attr_title )        : '';
		$class_names = (array) get_post_meta( $item->ID, '_menu_item_classes', true );		
		 //~ 判断第一个CSS类是否以 glyphicon 开头，是的话就当做 glyphicon 图标输出添加在链接文本前并删掉这个CSS类
		if ( ! empty( $class_names[0] ) && strpos( esc_attr( $class_names[0] ) , 'glyphicon' ) !== false && strpos( esc_attr( $class_names[0] ) , 'glyphicon' ) == 0 ){
			$glyphicon_icon = '<span class="glyphicon ' . esc_attr( $class_names[0] ) . '"></span> ';
			unset($class_names[0]);
		}
		$is_parent = 0;
		if ( $depth == 0 && ($args->depth)>=0 && in_array( 'menu-item-has-children', $item->classes ) ){
			$class_names[] = 'dropdown';
			$atts_class[] = 'dropdown-toggle';
			$atts['data-toggle'] = 'dropdown';
			$caret = ' <span class="caret_b"></span></a>';
			$is_parent = 1;
		}
		else{
			$class_names[] = 'dropdown';
		}
		if($depth!=0 && ($args->depth)>=0 && in_array( 'menu-item-has-children', $item->classes )){
			$caret = ' <span class="caret_r"></span></a>';
		}
		if( empty( $item->url ) && empty($atts['data-toggle']) ) $atts_class[] = 'navbar-text';
		if( $item->current || $item->current_item_ancestor || $item->current_item_parent ){
			$class_names[] = 'active';
		}
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $class_names ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';		
		$item_output .= '<li' . $class_names .'>';
		$atts['class'] = join('', $atts_class);
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$item_output .= $args->before;
		$item_output .= ( $item->url || !empty($atts['data-toggle']) ) ? '<a'. $attributes .' itemprop="url">' : '<div'. $attributes .'>';
		$item_output .= $args->link_before . $glyphicon_icon . apply_filters( 'the_title', $item->title, $item->ID ). $caret .$args->link_after;
		$item_output .= ( $item->url || !empty($atts['data-toggle']) ) ? '</a>' : '</div>';
		$item_output .= $args->after;
		$output .= $item_output;		
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>";
	}
}