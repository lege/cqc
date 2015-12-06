<?php  
add_action( 'widgets_init', 'wid-postzr' );

function d_tags() {
	register_widget( 'wid-postzr' );
}
class d_tag extends WP_Widget {
	function d_tag() {
		$widget_ops = array( 'classname' => 'd_tag', 'description' => '显示热门标签' );
		$this->WP_Widget( 'd_tag', 'D-标签云', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$count = $instance['count'];
		$offset = $instance['offset'];
		$more = $instance['more'];
		$link = $instance['link'];

		$mo='';
		if( $more!='' && $link!='' ) $mo='<a class="btn btn-primary" href="'.$link.'">'.$more.'</a>';

		echo $before_widget;
		echo $before_title.$mo.$title.$after_title; 
		echo '<div class="d_tags">';
		$tags_list = get_tags('orderby=count&order=DESC&number='.$count.'&offset='.$offset);
		if ($tags_list) { 
			foreach($tags_list as $tag) {
				echo '<a href="'.get_tag_link($tag).'">'. $tag->name .' ('. $tag->count .')</a>'; 
			} 
		}else{
			echo '暂无标签！';
		}
		echo '</div>';
		echo $after_widget;
	}

	function form($instance) {

?>