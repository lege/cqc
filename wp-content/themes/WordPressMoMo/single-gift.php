<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */

$is_can_edit_post = current_user_can('edit_post', get_queried_object_id());

if( !empty($_GET['api']) && $_GET['api']=='log' ){

	$title = sprintf( __('《%s》全部兑换记录', 'momo'), esc_html(get_the_title(get_queried_object_id())) );
	$buyers_list = $title . '<br><br>';
	
	if($is_can_edit_post){
		
		$exchange = get_dmeng_metas('exchange_'.get_queried_object_id());
		if( $exchange ){
			foreach( $exchange as $exterm ){

				$buyers_list .= sprintf( __(' %1$s 在 %2$s 兑换了一个，唯一识别码是 %3$s ', 'momo'), 
														get_the_author_meta( 'display_name', $exterm->user_id),
														$exterm->meta_value , 
														dmeng_get_exchange_key( $exterm->user_id , get_queried_object_id(), $exterm->meta_value )
														)
												. '<br>';
			}
		}else{
		
			$buyers_list .= __('没有找到兑换记录', 'momo');
			
		}
		
	}else{
		
		$buyers_list .= __('当前帐号没有查看权限', 'momo');
		
	}
	
	$buyers_list .= '<br><br><a href="'.get_permalink(get_queried_object_id()).'">'.__('&laquo; 返回查看内容', 'momo').'</a> / <a href="'.add_query_arg('api', 'check', get_post_type_archive_link( 'gift' ) ).'">'.__('查询兑换信息', 'momo').'</a>';
	wp_die( $buyers_list, $title , array( 'response'=>503 ) );
}

$gift_info = json_decode(get_post_meta( get_queried_object_id(), 'dmeng_gift_info', true ));
$buyers = (array)json_decode(get_post_meta( get_queried_object_id(), 'dmeng_gift_buyers', true ));
$uid = get_current_user_id();

if( isset($_GET['gift_attachment']) && isset($_GET['gift_wpnonce']) && $uid && in_array($uid, $buyers) ){
	$akey = intval($_GET['gift_attachment']);
	if ( wp_verify_nonce( $_GET['gift_wpnonce'],  'nonce_'.$akey ) ) {
		$akey = $akey-1;
		if( isset($gift_info->attachment[$akey]) ){
			$apath = get_attached_file($gift_info->attachment[$akey]);
			if(file_exists($apath)){
				
				$filetype = wp_check_filetype($apath);

				$filename = preg_replace('/^.+[\\\\\\/]/', '', $apath);

				$ua = $_SERVER["HTTP_USER_AGENT"];
				$encoded_filename = rawurlencode($filename);

				header("Content-type: ".$filetype['type']);
				
				if (preg_match("/MSIE/", $ua)) {
					header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
				} else if (preg_match("/Firefox/", $ua)) {
					header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
				} else {
					header('Content-Disposition: attachment; filename="' . $filename . '"');
				}
				
				header("Content-Length: ". filesize($apath));
				readfile($apath);
				
				exit;
			}
		}
	}
}

get_header(); ?>
<?php get_header('masthead'); ?>
<div id="main" class="container" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
	<div class="row">
			<?php 
				while ( have_posts() ) : the_post();

					$max = intval($gift_info->max);
					$stock = intval($gift_info->stock);

					$credit = intval($gift_info->credit)==0 ? __('免费', 'momo') : intval($gift_info->credit);

					$count_buyers = array_count_values($buyers);
					$exchange_num = isset($count_buyers[$uid]) ? intval($count_buyers[$uid]) : 0;

					echo '<article id="content" class="col-lg-8 col-md-8 single-gift" data-post-id="'. get_the_ID().'" role="article" itemscope itemtype="http://schema.org/Article">';

					$output = '<div class="row">';
					$output .= '<div class="col-lg-4 col-md-4 col-sm-4">';
					$thumbnail = dmeng_get_the_thumbnail();
					$output .= '<div class="entry-thumbnail gift-thumbnail"><a href="'.get_permalink().'" title="'.get_the_title().'"><img src="'.wpmomo_script_uri('grey_png').'" data-original="'.$thumbnail.'" alt="'.get_the_title().'"></a></div>';
					
					$exchange_btn = array(
						'status' => 1,
						'class' => 'btn-success',
						'title' => __('立即兑换', 'momo')
					);
					
					if( !$uid ){
						
						$exchange_btn = array(
							'status' => 0,
							'class' => 'btn-default',
							'title' => __('请先登录', 'momo')
						);
						
					}else{
						
						if( intval($gift_info->credit)==0 ) $exchange_btn['title'] = __('免费兑换', 'momo');

						if($stock!=0 && $stock<= count($buyers)){
							$exchange_btn = array(
								'status' => 0,
								'class' => 'btn-warning disabled',
								'title' => __('库存不足', 'momo')
							);
						}
						
						if( intval(get_user_meta($uid, 'dmeng_credit', true)) < intval($gift_info->credit) ){
							$exchange_btn = array(
								'status' => 0,
								'class' => 'btn-warning disabled',
								'title' => __('积分余额不足', 'momo')
							);
						}
						
						if($max!=0 && $exchange_num>=$max){
							$exchange_btn = array(
								'status' => 0,
								'class' => 'btn-danger disabled',
								'title' => __('已达到最大兑换数', 'momo')
							);
						}
						
					}
					
					$output .= sprintf('<a href="javascript:;" class="btn btn-block btn-exchange %s">%s</a>',  $exchange_btn['class'], $exchange_btn['title'] );
					$output .= '<p class="exchange-tips">';
						if($uid) $output .= sprintf(__('你已兑换 %s 次，', 'momo'), $exchange_num);
						$output .=  $max==0 ? __('可以无限量兑换', 'momo') : sprintf(__('每人最多兑换 %s 次', 'momo'), $max);
					$output .= '</p>';
					$output .= '</div>';
					
						$output .= '<div class="col-lg-8 col-md-8 col-sm-8">';
							$output .= sprintf('<h1 class="gift-title">%s</h1>', 
																	get_the_title() . ( ( is_preview() || $is_can_edit_post ) ? ' <small><a href="'.get_edit_post_link().'" data-no-instant>'.__('Edit This').'</a></small>' : '' )
															 );

							$express = dmeng_get_express_array();
							
							$gift_data_array = array(
								array(
									'name' => 'price',
									'title' => __('市场价格', 'momo'),
									'value' => sprintf("%.2f", intval($gift_info->price))
								),
								array(
									'name' => 'credit',
									'title' => __('所需积分', 'momo'),
									'value' => $credit
								),
								array(
									'name' => 'stock',
									'title' => __('库存数量', 'momo'),
									'value' => ( $stock==0 ? __('不限量', 'momo') : $stock)
								),
								array(
									'name' => 'buyers',
									'title' => __('兑换人次', 'momo'),
									'value' => count($buyers)
								),
								array(
									'name' => 'view',
									'title' => __('浏览次数', 'momo'),
									'value' => '<span data-num-views="true">'.get_dmeng_traffic('single',get_the_ID()).'</span>'
								),
								array(
									'name' => 'express',
									'title' => __('物流配送', 'momo'),
									'value' => $express[intval($gift_info->express)]
								),
								array(
									'name' => 'tips',
									'title' => __('温馨提示', 'momo'),
									'value' => get_option('dmeng_gift_tips', __('兑换成功后请留意信息通知，如有兑换后可见的内容可直接查看。', 'momo'))
								)
							);
							
							$output .= '<ul class="gift-info">';
							
							foreach( $gift_data_array as $gift_data ){
								$output .= sprintf('<li class="%s"><span class="label">%s</span><span>%s</span></li>', $gift_data['name'], $gift_data['title'], $gift_data['value'] );
							}
							$output .= '</ul>';

						$output .= '</div>';
						
					$output .= '</div>';
					
					if( $uid ){
						$exchang_id = $is_can_edit_post ? 0 : $uid;
						$exchange = get_dmeng_metas('exchange_'.get_the_ID(),  $exchang_id, ( $exchang_id ? '' : 10 ) );
						$buyers_list = '';
						
						if( $exchange ){
							foreach( $exchange as $exterm ){

									$buyers_list .= '<p>'.sprintf( __(' %1$s 在 %2$s 兑换了一个，唯一识别码是 %3$s ', 'momo'), 
																			( $exchang_id && $exterm->user_id==$uid ) ? __('你', 'momo') : get_the_author_meta( 'display_name', $exterm->user_id),
																			$exterm->meta_value , 
																			dmeng_get_exchange_key( $exterm->user_id , get_the_ID(), $exterm->meta_value )
																			)
																			. '</p>';
									
							}
							if( $exchang_id==0 ) $buyers_list .= '<p><a href="'.add_query_arg('api', 'log', get_permalink()).'" target="_blank">'.__('查看全部记录', 'momo').'</a> / <a href="'.add_query_arg('api', 'check', get_post_type_archive_link( 'gift' ) ).'" target="_blank">'.__('查询兑换信息', 'momo').'</a></p>';
						}
						
						if($buyers_list) $output .= '<div class="page-header">'.__('兑换记录', 'momo').'</div><div>'.$buyers_list.'</div>';
					}

					$dmeng_gift_notice = get_option('dmeng_gift_notice', '');
					if($dmeng_gift_notice) $output .= '<div class="page-header">'.__('兑换须知', 'momo').'</div><div>'.stripslashes(htmlspecialchars_decode($dmeng_gift_notice)).'</div>';
					
					if( $gift_info->content || $gift_info->attachment ){

							$output .= '<div class="page-header">';
								$output .= __('兑换后可见的内容', 'momo');
								if($gift_info->attachment) $output .= sprintf(__('，其中包括 %s 个附件', 'momo'), count($gift_info->attachment) );
							$output .= '</div>';
							$output .= '<div>';
								if( ( $uid && $exchange_num ) || $is_can_edit_post ){
									$output .= stripslashes(htmlspecialchars_decode($gift_info->content));
									if($gift_info->attachment){
										$output .= '<ul class="gift-attachment">';
										$output .= '<li>'.__('下载附件', 'momo').'</li>';
										foreach( $gift_info->attachment as $attachment_array_key=>$attachment_id ){
											$akey = ($attachment_array_key+1);
											$apath = get_attached_file($attachment_id);
											$filetype = wp_check_filetype(basename($apath));
											$output .= sprintf( __('<li><a href="%s" target="_blank">%s</a> | %s | %s </li>', 'momo'), add_query_arg( array( 'gift_attachment'=>$akey, 'gift_wpnonce'=>wp_create_nonce( 'nonce_'.$akey ) ) ), get_the_title($attachment_id), $filetype['ext'], size_format(filesize($apath))  );
										}
										$output .= '</ul>';
									}
								}else{
									$output .=__('要查看内容请先兑换。', 'momo');
								}
							$output .= '</div>';

					}

					$content = str_replace( ']]>', ']]&gt;',apply_filters( 'the_content', get_the_content() ) );
					if( $content ){
						$output .= '<div class="page-header">'.__('礼品介绍', 'momo').'</div><div class="entry-content">';
						$output .= $content;
						$output .= dmeng_post_page_nav(false);
						$output .= '</div>';
					}

					if( $uid && $exchange_btn['status'] ){
						$output .= '<div class="modal fade gift-exchange-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"><div class="modal-dialog modal-sm"><div class="modal-content">';
							$output .= '<div class="modal-header"><h4 class="modal-title">'.__('确认操作', 'momo').'</h4></div>';
		  
							$output .= '<div class="modal-body">'.sprintf( __('你正在兑换“%s”，请确认操作。', 'momo'), get_the_title()).'<div class="small text-danger">'.sprintf( __('需要花费 %s 积分', 'momo'), intval($gift_info->credit)).'</div></div>';
		  
							$output .= '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">'.__('取消', 'momo').'</button><button type="button" class="btn btn-danger btn-exchange-submit">'.__('确认兑换', 'momo').'</button></div>';
		  
						$output .= ' </div></div></div>';
					}
					
					 echo '<div class="panel panel-default"><div class="panel-body">'.$output.'</div>';
					 
					dmeng_post_footer();
					
					echo  '</div>';
					
					?>
					<div class="panel panel-default" id="comments" data-no-instant><?php comments_template( '', true ); ?></div>
					<?php
					echo '</article>';
					
				endwhile; // end of the loop. 
				dmeng_paginate();
			?>
		<?php get_sidebar();?>
	</div>
 </div><!-- #main -->
<?php get_footer('colophon'); ?>
<?php get_footer(); ?>
