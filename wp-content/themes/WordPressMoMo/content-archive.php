<?php

/*
 * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦
 */

$title = esc_html(get_the_title());

$excerpt = apply_filters( 'the_excerpt', get_the_excerpt() );

if( is_search() ){
	$keyword = get_search_query();
	$title = dmeng_highlight_keyword($keyword, $title);
	$excerpt = dmeng_highlight_keyword($keyword, $excerpt);
}

$panel_class = 'panel panel-default archive';

if( $post->post_status!='publish' )
	$panel_class .= ' text-muted';
?>

		<article id="post-<?php the_ID(); ?>" class="<?php echo apply_filters('dmeng_archive_post_panel_class', $panel_class);?>" data-post-id="<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/Article">

					
					<?php

					$thumbnail_html = $has_thumbnail_class = '';
					$thumbnail = dmeng_get_the_thumbnail();
					$thumoption = json_decode(get_option('dmeng_post_thumbnail','{"on":"1","TimThumb":"0","thumbnail_method":"1","thumbnail_quality":"90"}'), true);

					$zc = $thumoption['thumbnail_method'];

					$q = $thumoption ['thumbnail_quality'];

					$timthumb = $thumoption['TimThumb'];

					$thummore =  get_bloginfo('template_url')."/timthumb.php?src=$thumbnail&h=200&w=220&zc=$zc&q=$q";

					$thummore = $timthumb==0 ? $thummore : $thumbnail ;						
					
					if($thumbnail){

						$thumbnail_html =  '<div class="entry-thumbnail"><a href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.wpmomo_script_uri('grey_png').'" data-original="'.$thummore.'" alt="'.get_the_title().'"></a></div>';

						$has_thumbnail_class = ' has_post_thumbnail';

					}

					?>

				<div class="panel-body<?php echo $has_thumbnail_class;?>">



					<?php if($thumbnail_html) echo $thumbnail_html;?>



					<div class="entry-header page-header">



						<h3 class="entry-title">



						<?php



							echo apply_filters( 'dmeng_the_title', '<a href="'.get_permalink().'" rel="bookmark" itemprop="url"><span itemprop="name">'.$title.'</span></a>' );



							if( is_sticky() )



								echo ' '.apply_filters( 'dmeng_sticky_label', '<span class="label label-danger">'.__('置顶','momo').'</span>');



						?>



						</h3>



						<?php 



						if( $post->post_status!='publish' ){



							$meta_output = '<div class="entry-meta">';



								if( $post->post_status==='pending' ) $meta_output .= sprintf(__('正在等待审核，你可以 <a href="%1$s">预览</a> 或 <a href="%2$s" data-no-instant>重新编辑</a> 。','momo'), get_permalink(), get_edit_post_link() );



								if( $post->post_status==='draft' ) $meta_output .= sprintf(__('这是一篇草稿，你可以 <a href="%1$s">预览</a> 或 <a href="%2$s" data-no-instant>继续编辑</a> 。','momo'), get_permalink(), get_edit_post_link() );



							$meta_output .= '</div>';



							echo $meta_output;



						}else{

							dmeng_post_meta();


						}

						?>


					</div>

					<div class="entry-content" itemprop="description" data-no-instant><?php echo $excerpt;?></div>

					<div class="entry-tag"><?php echo get_the_tag_list('<span class="glyphicon glyphicon-tags theme-color-font" style="margin-right:10px;top:3px;"></span>','&nbsp&nbsp&nbsp'); ?></div>



				</div>



		 </article><!-- #content -->



