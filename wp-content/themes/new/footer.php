</section>

<?php wp_reset_query(); if ( is_home()) { ?>
	
<?php } ?>


<footer class="footer">
    <div class="footer-inner">
        <div class="copyright pull-left">
            Theme by <a href="http://www.nocower.com/5013.html" target="_blank" title="主题来自One">One</a>  &copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> |  <?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>
        </div>
    </div>	
</footer>
<?php wp_footer(); ?>
<script src="<?php bloginfo('template_url'); ?>/js/common.js"></script>
<?php if ( !is_single() ) { ?>
<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=6&amp;mini=1&amp;pos=right&amp;uid=6456010" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
<!-- Baidu Button END -->
<?php } ?>
<?php
if( dopt('d_footcode_b') ) echo dopt('d_footcode'); 
?>


<script type="text/javascript">// <![CDATA[
$.fn.smartFloat = function() {
var position = function(element) {
var top = element.position().top, pos = element.css("position");
$(window).scroll(function() {
var scrolls = $(this).scrollTop();
if (scrolls > top) {
if (window.XMLHttpRequest) {
element.css({
position: "fixed",
top: 47
});
} else {
element.css({
top: scrolls
});
}
}else {
element.css({
position: pos,
top: top
});
}
});
};
return $(this).each(function() {
position($(this)); 
});
};
 
//绑定
$("#blad").smartFloat();
// ]]></script>
</body>
</html>