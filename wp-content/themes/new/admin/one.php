<?php

$themename = $dname.'主题';

$options = array(
    "d_description", "d_keywords", "d_tui", "d_logo_w", "d_sticky_b", "d_sticky_count", "d_linkpage_cat", "d_tougao_b", "d_tougao_time", "d_avatar_b", "d_avatarDate", "d_sideroll_b", "d_sideroll_1", "d_sideroll_2", "d_pingback_b", "d_autosave_b", "d_tqq_b", "d_tqq", "d_weibo_b", "d_weibo", "d_facebook_b", "d_facebook", "d_twitter_b", "d_twitter", "d_rss", "d_bdshare", "d_maillist_b", "d_maillist", "d_track_b", "d_track", "d_headcode_b", "d_headcode", "d_footcode_b", "d_footcode", "d_adsite_01_b", "d_adsite_01", "d_adindex_02_b", "d_adindex_02", "d_adindex_01_b", "d_adindex_01", "d_adindex_03_b", "d_adindex_03", "d_adpost_01_b", "d_adpost_01", "d_adpost_02_b", "d_adpost_02", "d_adpost_03_b", "d_adpost_03"
);

function mytheme_add_admin() {
    global $themename, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                update_option( $value, $_REQUEST[ $value ] ); 
            }
            header("Location: admin.php?page=wf.php&saved=true");
            die;
        }
    }
    add_theme_page($themename." Options", $themename."控制台", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
    global $themename, $options;
    $i=0;
    if ( $_REQUEST['saved'] ) echo '<div class="updated settings-error"><p>'.$themename.'修改已保存</p></div>';
?>

<div class="wrap d_wrap">
    <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/admin/admin.css"/>
    <h2><?php echo $themename; ?>控制台
        <span class="d_themedesc">主题作者：<a href="http://www.nocower.com/5013.html" target="_blank">马赐崇</a></span>
    </h2>

<form method="post" class="d_formwrap" style=" width: 80%; margin: 0 auto; border: 1px solid #DDD; padding: 20px; box-shadow: 0 5px 40px #ACACAC; ">
    <table>
    <thead>
        <tr>
            <th width="200"></th>
            <th></th>
        </tr>
    </thead>
    <tr>
        <td class="d_tit">网站描述【Description】</td>
        <td>
            <input class="ipt-b" type="text" id="d_description" name="d_description" value="<?php echo dopt('d_description'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">网站关键字【Keywords】</td>
        <td>
            <input class="ipt-b" type="text" id="d_keywords" name="d_keywords" value="<?php echo dopt('d_keywords'); ?>">
        </td>
    </tr>
    <tr>
        <td class="d_tit">Logo（标志）宽度</td>
        <td>
            <input class="d_num" name="d_logo_w" id="d_logo_w" type="number" value="<?php echo dopt('d_logo_w'); ?>"> px（像素）
            <span class="d_tip">Logo图片在主题【IMG】文件夹下替换logo.png，高度为必须为【40px】，默认宽度【120PX】</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">首页置顶推荐</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_sticky_b" name="d_sticky_b" <?php if(dopt('d_sticky_b')) echo 'checked="checked"' ?>>开启
            </label>
            （建议勾选）此处显示的文章需要设置置顶
        </td>
    </tr>
    <tr>
        <td class="d_tit">友情链接页面</td>
        <td>
            <label class="checkbox inline">
               友情链接请在【后台—主题—菜单】新建一个菜单，应用到友情链接
                &nbsp; &nbsp;
            </label>
        </td>
    </tr>
    <tr>
        <td class="d_tit">投稿</td>
        <td>
          到后台新建一个页面，模板选择【投稿页面】即可
        </td>
    </tr>
    <tr>
        <td class="d_tit">禁止站内文章Pingback</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_pingback_b" name="d_pingback_b" <?php if(dopt('d_pingback_b')) echo 'checked="checked"' ?>>开启
                &nbsp; &nbsp;
                <span class="d_tip">开启后，不会发送站内Pingback，建议开启</span>
            </label>
        </td>
    </tr>
    <tr>
        <td class="d_tit">禁止后台编辑时自动保存</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_autosave_b" name="d_autosave_b" <?php if(dopt('d_autosave_b')) echo 'checked="checked"' ?>>开启
                &nbsp; &nbsp;
                <span class="d_tip">开启后，后台编辑文章时候不会定时保存，有效缩减数据库存储量；但是，一般不建议开启，除非你的数据库容量很小</span>
            </label>
        </td>
    </tr>
    
    <tr>
        <td class="d_tit">RSS订阅地址</td>
        <td>
            <input class="d_inp_short" name="d_rss" id="d_rss" type="text" value="<?php echo dopt('d_rss'); ?>">
            <span class="d_tip">可以是其他订阅托管站点的地址/会显示在边栏订阅弹出窗口</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">腾讯邮件列表</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_maillist_b" name="d_maillist_b" <?php if(dopt('d_maillist_b')) echo 'checked="checked"' ?>>开启
            </label>
            key：
            <input class="d_inp_short" name="d_maillist" id="d_maillist" type="text" value="<?php echo dopt('d_maillist'); ?>">
            <br><span class="d_tip">开启时，点击页面订阅按钮时会有一个邮件订阅模块，站点更新时自动发布文章到订阅者邮箱/边栏底部订阅模块<a href="http://list.qq.com/" target="_blank">去看看</a></span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">流量统计代码</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_track_b" name="d_track_b" <?php if(dopt('d_track_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_track" id="d_track" type="textarea" rows="4"><?php echo dopt('d_track'); ?></textarea>
            <span class="d_tip">统计网站流量，推荐使用百度统计，国内比较优秀且速度快；还可使用Google统计、CNZZ等</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">页面头部公共代码</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_headcode_b" name="d_headcode_b" <?php if(dopt('d_headcode_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_headcode" id="d_headcode" type="textarea" rows="4"><?php echo dopt('d_headcode'); ?></textarea>
            <span class="d_tip">会自动出现在页面头部（head区域），可放置广告代码等自定义（css或js）的全局代码块</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">页面底部公共代码</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_footcode_b" name="d_footcode_b" <?php if(dopt('d_footcode_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_footcode" id="d_footcode" type="textarea" rows="4"><?php echo dopt('d_footcode'); ?></textarea>
            <span class="d_tip">同上，但是在全站页面底部出现</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">广告：全站 - 导航下横幅</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_adsite_01_b" name="d_adsite_01_b" <?php if(dopt('d_adsite_01_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_adsite_01" id="d_adsite_01" type="textarea" rows=""><?php echo dopt('d_adsite_01'); ?></textarea>
            <span class="d_tip">广告区域，任意联盟广告和自定义广告的代码均可，下同</span>
        </td>
    </tr>
    <tr>
        <td class="d_tit">广告：全站正文列表最前</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_adindex_02_b" name="d_adindex_02_b" <?php if(dopt('d_adindex_02_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_adindex_02" id="d_adindex_02" type="textarea" rows=""><?php echo dopt('d_adindex_02'); ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="d_tit">广告：首页 - 导航下横幅</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_adindex_01_b" name="d_adindex_01_b" <?php if(dopt('d_adindex_01_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_adindex_01" id="d_adindex_01" type="textarea" rows=""><?php echo dopt('d_adindex_01'); ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="d_tit">广告：文章页 - 页面标题下</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_adpost_01_b" name="d_adpost_01_b" <?php if(dopt('d_adpost_01_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_adpost_01" id="d_adpost_01" type="textarea" rows=""><?php echo dopt('d_adpost_01'); ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="d_tit">广告：文章页 - 相关文章下</td>
        <td>
            <label class="checkbox inline">
                <input type="checkbox" id="d_adpost_02_b" name="d_adpost_02_b" <?php if(dopt('d_adpost_02_b')) echo 'checked="checked"' ?>>开启
            </label>
            <textarea name="d_adpost_02" id="d_adpost_02" type="textarea" rows=""><?php echo dopt('d_adpost_02'); ?></textarea>
        </td>
    </tr>
      <tr>
        <td class="d_tit">边栏唯一广告位</td>
        <td>
            <textarea name="d_tui" id="d_tui" type="textarea" rows=""><?php echo dopt('d_tui'); ?></textarea>
            <span class="d_tip">边栏唯一的广告位/下拉后可以浮动/最佳展示位置</span>
        </td>
    </tr>
    
 <tr>
        <td class="d_tit">希望各位站长能够点击右侧广告使用阿里云支持主题更新，谢谢！<br>
另外不保留主题底部版权的人不要使用本主题，也不要加群。
<br>
Wordpress交流群：288325802</td>
        <td>
            <iframe width="760" height="90" src="http://www.taobao.com/go/rgn/union/aliyun_ecs.php?size=760x90&pid=mm_41374337_0_0" frameborder="0" marginheight="0" marginwidth="0" border="0" scrolling="no" name="alimamaifrm"></iframe>
        </td>
    </tr>


    <tr>
        <td class="d_tit"></td>
        <td>
            <div class="d_desc">
                <input class="button-primary" name="save" type="submit" value="保存设置">
            </div>
            <input type="hidden" name="action" value="save">
        </td>
    </tr>

    </table>
</form>
</div>
<script>
var aaa = []
jQuery('.d_wrap input, .d_wrap textarea').each(function(e){
    if( jQuery(this).attr('id') ) aaa.push( jQuery(this).attr('id') )
})
console.log( aaa )
</script>
<?php } ?>
<?php add_action('admin_menu', 'mytheme_add_admin');?>