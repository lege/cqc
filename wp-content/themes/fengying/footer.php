  <div class="footer">
    <div class="common">
      <div class="left">Powered by <a href="http://wordpress.org" rel="external nofollow" target="_blank">WordPress</a>. Theme by <a href="http://www.zlphp.com" target="_blank">郑力</a>.</div>
      <div class="right">
        <?php echo get_option('blog_stats'); ?>　<?php echo get_option('blog_copyright'); ?></div>
    </div>
  </div>
  <a class="backtop" href=""></a>
</div>
<script type="text/javascript">document.write("<scr"+"ipt src=\"<?php bloginfo('template_url'); ?>/include/jquery.1.4.2.min.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"<?php bloginfo('template_url'); ?>/include/custom.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"<?php bloginfo('template_url'); ?>/include/slider.js\"></sc"+"ript>")</script>
<script type="text/javascript">document.write("<scr"+"ipt src=\"<?php bloginfo('template_url'); ?>/include/tw_cn.js\"></sc"+"ript>")</script>
<script type="text/javascript">
var defaultEncoding = 0;
var translateDelay = 0;
var cookieDomain = "<?php echo esc_url(home_url('')); ?>";
var msgToTraditionalChinese = "繁體";
var msgToSimplifiedChinese = "简体";
var translateButtonId = "translatelink";
translateInitilization();
</script>
<?php if(is_single()){ ?>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6529584" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)</script>
<?php } ?>
</body>
</html>