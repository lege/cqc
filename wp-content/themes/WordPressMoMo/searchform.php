<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */
 ?>
<form class="input-group input-group-sm" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	
	<input type="text" class="form-control form-control1" placeholder="<?php _e('搜索 &hellip;','momo');?>" name="s" id="s" required>
	
	<span class="input-group-btn">
		<button type="submit" class="btn btn-default btn-default1" id="searchsubmit">
			<span class="glyphicon glyphicon-search"></span>
		</button>
	</span>

</form>
