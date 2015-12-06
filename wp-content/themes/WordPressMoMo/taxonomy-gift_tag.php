<?php
/* * 亲，如果您喜欢本主题或者有任何意见，请上http://www.wpmomo.com与发表留言哦 */
 
 //~ 积分换礼使用统一的归档页

wp_redirect( add_query_arg('t', get_queried_object_id(), get_post_type_archive_link( 'gift' )), 301 );
exit;
