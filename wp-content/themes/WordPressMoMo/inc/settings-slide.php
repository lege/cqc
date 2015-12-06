<?php

/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com发表留言哦 */

 

/*

 * 主题设置页面  

 * 

 * @option dmeng_slides 所有幻灯片ID

 * @option dmeng_slide_{id} 单个幻灯片数据

 */

 

function dmeng_options_slide_page(){



	$do =  isset($_GET['do']) ? sanitize_text_field($_GET['do']) : 0;

	$id =  isset($_GET['id']) ? intval($_GET['id']) : 0;



	$slides = $new_slides = array();

	$slide_id =  $id;

	$slides = json_decode(get_option('dmeng_slides','[]'));



	if( $id && in_array($do,array('delete','home','rfhome')) && isset($_GET['_wpnonce']) && wp_verify_nonce( trim($_GET['_wpnonce']), 'check_for_'.$id ) ){

		

		$message = __('没有发生变化。','momo');

		

		if( $do=='delete' ){

			if(delete_option('dmeng_slide_'.$id)){

				foreach($slides as $all_id ){

						if($all_id!=$id) $new_slides[] = $all_id;

				}

				update_option('dmeng_slides',json_encode($new_slides));

				$message = __('删除成功。','momo');

				$slides = $new_slides;

			}

		}

		

		if( $do=='home'  &&  in_array($id,$slides) && update_option('dmeng_slide_home',$id)) $message = __('首页幻灯片已更新。','momo');



		if( $do=='rfhome' && $id == get_option('dmeng_slide_home') && delete_option('dmeng_slide_home') ) $message = __('首页幻灯片已取消。','momo');



		dmeng_settings_error('updated',$message);

	}





  if( isset($_POST['action']) && wp_verify_nonce( trim($_POST['_wpnonce']), 'check-nonce' ) ) :

	

	if(sanitize_text_field($_POST['action'])=='update-slide' ){



		if( !in_array(intval($_POST['slide_id']),$slides) ){

			$slides[] = intval($_POST['slide_id']);

			update_option('dmeng_slides',json_encode($slides));

		}

		

		update_option(

			'dmeng_slide_'.intval($_POST['slide_id']),

			json_encode(array(

				'name' => $_POST['slide_name'],

				'img' => $_POST['slide_img'],

				'url' => $_POST['slide_url'],

				'title' => $_POST['slide_title'],

				'desc' => $_POST['slide_desc']

			))

		);

		update_option( 'slidee', $_POST['slideeffect']);

		if(intval($_POST['slide_is_new'])){

			?>

			<script>window.location.href='<?php echo admin_url('admin.php?page=dmeng_options_slide');?>';</script>

			<?php

		}

	}

	

    dmeng_settings_error('updated');

	  

  endif;





	

	?>

<style>

#slide-list li{font-size: 13px;line-height:36px;color: #777;background:#fff;border:1px solid #e1e1e1;}

#slide-list li p{padding:0 12px;margin: 0;line-height: 36px;}

#slide-list li .slide_preview{border-top:1px solid #e5e5e5;padding-top:10px;margin-bottom: 0px;}

#slide-list li .slide_preview img{width: 32%;margin-right: 1%;}

#slide-list span{margin-right:12px;}

.slide-table{background:#fff;border:1px solid #e1e1e1;}

.slide-table .title{padding-left:15px;}

</style>

<div class="wrap1">

	<h2><?php _e('WordPress MoMo','momo');?></h2>

	

	

	<form method="post" id="table-form">

		<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'check-nonce' );?>">

		<h3 class="title"><?php _e('幻灯片设置','momo');?></h3>

		<p><?php printf(__( '小提示：为了保证最佳的用户体验，请以 750px 作为图片宽度，同一组的图片采用一致高度，图片编辑完成后使用压缩工具压缩以提升加载速度，如 %1$s 可减少图片 70%% 体积。如果你不能保证图片的尺寸和质量，那么我们不建议你使用幻灯片，糟糕的幻灯片会严重影响网站的美观性！', 'momo' ), '<a href="https://tinypng.com/" target="_blank">TinyPNG</a>');?></p>



<?php



if($slide_id && $do && $do=='edit' ){



	if( in_array($slide_id,$slides) ){

		$slide_data = json_decode(get_option('dmeng_slide_'.$slide_id));

		$slide_is_new = 0;

	}else{

		$slide_data = json_decode('{"name":"","img":[""],"url":[""],"title":[""],"desc":[""]}');

		$slide_id = time();

		$slide_is_new = 1;

	}



	$name = $slide_data->name;

	$img = $slide_data->img;

	$url = $slide_data->url;

	$title = $slide_data->title;

	$desc = $slide_data->desc;

	$count = count($img)<1 ? 1 : count($img);



?>

<label for="slideeffect">



    请选择幻灯片切换效果



</label>

<?php $sselected = get_option('slidee')==1 ? '' : 'selected'; ?>

		<select id="slideeffect" name="slideeffect">



    <option value="1">滑动式</option>

    <option  <?php echo $sselected ?> value="2">淡入淡出式</option>

   



</select>


		<p><?php _e( '图片必须要有！否则前台不显示该项。', 'momo' );?></p>

		<input type="hidden" name="action" value="update-slide">

		<input type="hidden" name="slide_id" value="<?php echo $slide_id;?>">

		<input type="hidden" name="slide_is_new" value="<?php echo $slide_is_new;?>">



		<table class="form-table">

			<tbody>

				<tr>

					<th scope="row"><label for="slide_name"><?php _e( '幻灯片名称', 'momo' );?></label></th>

					<td>

						<input name="slide_name" type="text" id="slide_name" value="<?php echo $name;?>" class="regluar-text ltr">

					</td>

				</tr>

				<tr>

					<th scope="row"><label for="slide_name"><?php _e( '短代码', 'momo' );?></label></th>

					<td>

						[dmengslide id="<?php echo $slide_id;?>"]

					</td>

				</tr>

			</tbody>

		</table>

		

<?php

	for ($i = 1; $i <= $count; $i++) {

		$n = $i-1;

	?>

		<table class="form-table slide-table" id="slide_table_<?php echo $i;?>">

			<tbody>

				<tr>

					<th scope="row" class="title"><?php _e( '图片（必须）', 'momo' );?></th>

					<td>

						<input type="text" name="slide_img[]" id="slide_img_<?php echo $i;?>" value="<?php echo $img[$n];?>" class="slide_img regular-text"> 

						<a href="javascript:;" class="button slide_upload_button" data-id="slide_img_<?php echo $i;?>"><?php _e( '选择或上传', 'momo' );?></a> 

						<a href="javascript:;" class="button slide_preview_button" data-id="slide_img_<?php echo $i;?>"><?php _e( '预览', 'momo' );?></a> 

						</td>

				</tr>

				<tr>

					<th scope="row" class="title"><?php _e( '链接', 'momo' );?></th>

					<td><input type="text" name="slide_url[]" value="<?php echo $url[$n];?>" class="slide_url regular-text"></td>

				</tr>

				<tr>

					<th scope="row" class="title"><?php _e( '标题', 'momo' );?></th>

					<td><input type="text" name="slide_title[]" value="<?php echo $title[$n];?>" class="slide_title regular-text"></td>

				</tr>

				<tr>

					<th scope="row" class="title"><?php _e( '描述', 'momo' );?></th>

					<td><input type="text" name="slide_desc[]" value="<?php echo $desc[$n];?>" class="slide_desc regular-text"></td>

				</tr>

				<tr>

					<th scope="row" class="title"><?php _e( '幻灯片', 'momo' );?> <span class="slide_num"><?php echo $i;?></span></th>

					<td>

						<a href="javascript:;" class="button table_up"><?php _e( '往上移', 'momo' );?></a>

						<a href="javascript:;" class="button table_down"><?php _e( '往下移', 'momo' );?></a>

						<a href="javascript:;" class="button delete_table"><?php _e( '删除', 'momo' );?></a>

						<a href="javascript:;" class="button slide_new_button"><?php _e( '添加一项', 'momo' );?></a>

					</td>

				</tr>

			</tbody>

		</table>



<?php

	}

?>

		<p class="submit">

			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( '保存更改', 'momo' );?>"> 

			<?php if(!$slide_is_new){ ?>

			<a href="<?php echo add_query_arg(array('do'=>'delete','id'=>$slide_id,'_wpnonce'=>wp_create_nonce( 'check_for_'.$slide_id )));?>" class="button confirm_slide" title="<?php _e('删除','momo');?><?php echo $name;?>"><?php _e( '删除', 'momo' );?></a>

			<?php } ?>

		</p>

<?php

}else{

	

	$slide_home = intval(get_option('dmeng_slide_home',0));



?>

		<p><?php _e( '新建/管理幻灯片或设置首页幻灯片。', 'momo' );?></p>

	<input type="hidden" name="action" value="update-options">



<ul id="slide-list">

	<li><p>

		<?php printf( __('现在有 %1$s 组幻灯片，你可以选择管理或 <a href="%2$s"  class="button">新建幻灯片</a> 。','momo'), count($slides), add_query_arg(array('do'=>'edit','id'=>1)));?>

		<?php if($slide_home && in_array($slide_home,$slides)) printf( __('其中 %s 已设为首页幻灯片。','momo'), $slide_home );?>

	</p></li>

<?php

	if(count($slides)){

		foreach($slides as $slide_id){

			$slide = json_decode(get_option('dmeng_slide_'.$slide_id, '[]'));

		?>

	<li>

		<p>

			<span><?php _e('名称','momo');?> : <?php echo $slide->name;?></span>

			<span><?php _e('短代码','momo');?> : [dmengslide id="<?php echo $slide_id;?>"]</span>

			<span><?php _e('操作','momo');?> : <a href="<?php echo add_query_arg(array('do'=>'edit','id'=>$slide_id));?>" class="button"><?php _e('编辑','momo');?></a> <a href="<?php echo add_query_arg(array('do'=>'delete','id'=>$slide_id,'_wpnonce'=>wp_create_nonce( 'check_for_'.$slide_id )));?>" title="<?php _e('删除','momo');?><?php echo $slide->name;?>" class="button confirm_slide"><?php _e('删除','momo');?></a></span>

		

		<?php if( $slide_home && $slide_id == $slide_home ) { ?>

			<span><a href="<?php echo add_query_arg(array('do'=>'rfhome','id'=>$slide_id,'_wpnonce'=>wp_create_nonce( 'check_for_'.$slide_id )));?>" title="<?php _e('取消首页幻灯片','momo');?>" class="confirm_slide"><?php _e('取消首页幻灯片','momo');?></a></span>

		<?php }else{ ?>

			<span><a href="<?php echo add_query_arg(array('do'=>'home','id'=>$slide_id,'_wpnonce'=>wp_create_nonce( 'check_for_'.$slide_id )));?>" title="<?php _e('设为首页幻灯片','momo');?>" class="button confirm_slide"><?php _e('设为首页幻灯片','momo');?></a></span>

		<?php } ?>

		</p>

		<p class="slide_preview">

			<?php foreach( $slide->img as $slide_img ){

					if($slide_img) echo '<img src="'.$slide_img.'">';

				};?>

		</p>

	</li>

		<?php

		}

	}

?>



</ul>



<?php } ?>

		

	</form>

</div>

<?php wp_enqueue_media(); ?>

<script type="text/javascript">

jQuery(document).ready(function($){

	var upload_frame;   

    var value_id;   

    jQuery('.slide_upload_button').live('click',function(event){

        value_id =jQuery( this ).attr('data-id');       

        event.preventDefault();   

        if( upload_frame ){   

            upload_frame.open();   

            return;   

        }   

        upload_frame = wp.media({

            multiple: false   

        });   

        upload_frame.on('select',function(){ 

            attachment = upload_frame.state().get('selection').first().toJSON();   

            jQuery('#'+value_id).val(attachment.url);

        });   

        upload_frame.open();

    });

	jQuery('.slide_preview_button').live('click',function(event){

		var id = jQuery(this).attr('data-id');

		window.open(jQuery('#'+id).val());

    });

	jQuery('.slide_new_button').live('click',function(event){

		var l = jQuery('#table-form').children('.slide-table').length+1;

		var table = jQuery(this).parents('.slide-table').clone(true);

		table.attr('id','slide_table_'+l);

		table.find('.slide_img').attr('id','slide_img_'+l);

		table.find('.slide_upload_button').attr('data-id','slide_img_'+l);

		table.find('.slide_preview_button').attr('data-id','slide_img_'+l);

		table.find('input.slide_img').val('');

		table.find('input.slide_url').val('');

		table.find('input.slide_title').val('');

		table.find('input.slide_desc').val('');

		table.find('.slide_num').html(l);

		jQuery('p.submit').before(table);

    });

	jQuery('.table_up').live('click',function(event){

		var table = jQuery(this).parents('.slide-table');

		table.prev('.slide-table').before(table);

    });

	jQuery('.table_down').live('click',function(event){

		var table = jQuery(this).parents('.slide-table');

		table.next('.slide-table').after(table);

    });

	jQuery('.delete_table').live('click',function(event){

		if(jQuery('#table-form').children('.slide-table').length>1) jQuery(this).parents('.slide-table').remove();

    });

	jQuery('.confirm_slide').live('click',function(event){

		var r = confirm( $(this).attr('title')+' ? ' );

		if ( r == false ) return false;

    });

});



</script>

	<?php

}

