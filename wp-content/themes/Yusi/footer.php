</section>
<footer class="footer">
    <div class="footer-inner">
        <div class="copyright pull-left">
         <a href="<?php echo get_option('home'); ?> " title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> 版权所有丨采用<a href="http://yusi123.com/"> 欲思 </a>主题丨基于<a href="http://cn.wordpress.org/" title="WordPress"> WordPress </a>构建   © 2015丨托管于 <a rel="nofollow" target="_blank" href="http://www.aliyun.com/">阿里云主机</a> & <a rel="nofollow" target="_blank" href="http://www.qiniu.com/">七牛云存储 </a>丨鲁ICP备14030596号
		 <div>
			<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253486800'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1253486800%26online%3D1%26show%3Dline' type='text/javascript'%3E%3C/script%3E"));</script>
		 </div>
		</div>
        
    </div>
</footer>

<?php 
wp_footer(); 
global $dHasShare; 
if($dHasShare == true){ 
	echo'<script>with(document)0[(getElementsByTagName("head")[0]||body).appendChild(createElement("script")).src="http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion="+~(-new Date()/36e5)];</script>';
}  
if( dopt('d_footcode_b') ) echo dopt('d_footcode'); 
?>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3ef185224776ec2561c9f7066ead4f24' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>
</html>