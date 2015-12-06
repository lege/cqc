<?php
/*
Template Name:高亮代码
*/
?>
<?php get_header(); ?>

<div class="bodybox">
  <div class="main">
    <div class="common">
      <?php if(have_posts()):while(have_posts()):the_post(); ?>
	  <div class="list">
        <div class="position">
          <div class="positiontxt"><?php if(function_exists('wp_breadcrumbs')){wp_breadcrumbs();} ?></div>
        </div>
		<div class="contentbox">
          <div class="contenttitle">
            <h1><?php the_title(); ?></h1>
		  </div>
		  <div class="clear"></div>
          <div class="contenttxt">
            <?php the_content(); ?>
		    <script type="text/javascript">document.write("<scr"+"ipt src=\"<?php bloginfo('template_url'); ?>/include/highlighter.js\"></sc"+"ript>")</script>
		    <div class="highlighterbox">
		      <h3>输入源代码</h3>
			  <textarea class="php" id="sourceCode" name="sourceCode"></textarea>
			  <span class="options">选择语言：
		  	  <select onchange="document.getElementById('sourceCode').className=this.value">
              <option value="java">java</option>
              <option value="xml">xml</option>
              <option value="sql">sql</option>
              <option value="jscript">jscript</option>
              <option value="groovy">groovy</option>
              <option value="css">css</option>
              <option value="cpp">cpp</option>
              <option value="c#">c#</option>
              <option value="python">python</option>
              <option value="vb">vb</option>
              <option value="perl">perl</option>
              <option value="php" selected>php</option>
              <option value="ruby">ruby</option>
              <option value="delphi">delphi</option>
              </select>
              </span>
		  	  <span class="options">
			  <span class="options_no">
			  <input id="showGutter" type="checkbox" checked="checked">显示行号
              <input id="firstLine" type="checkbox" checked="checked">起始为1
              <input id="showControls" type="checkbox">工具栏
              <input id="collapseAll" type="checkbox">折叠
              <input id="showColumns" type="checkbox">显示列数
		  	  </span>
			  </span>
			  <span class="render">
			  <button onclick="generateCode()">转换</button>
              <button onclick="clearText()">清除</button>
              </span>
			  <h3>HTML代码</h3>
              <textarea id="htmlCode" name="htmlCode"></textarea>
		  	  <h3>HTML预览</h3>
              <div id="preview"></div>
		    </div>
          </div>
        </div>
      </div>
	  <?php endwhile; endif;?>
      <div class="sidebar">
		<?php if(is_dynamic_sidebar())dynamic_sidebar('right_sidebar'); ?>
        <div class="widgets" id="float">
          <div class="adbox">
            <div class="adimg">
              <ul>
<?php if(get_option('blog_ad1')!=""){ ?><li><?php echo get_option('blog_ad1'); ?></li><?php } ?>
<?php if(get_option('blog_ad2')!=""){ ?><li><?php echo get_option('blog_ad2'); ?></li><?php } ?>
<?php if(get_option('blog_ad3')!=""){ ?><li><?php echo get_option('blog_ad3'); ?></li><?php } ?>
<?php if(get_option('blog_ad4')!=""){ ?><li><?php echo get_option('blog_ad4'); ?></li><?php } ?>
<?php if(get_option('blog_ad5')!=""){ ?><li><?php echo get_option('blog_ad5'); ?></li><?php } ?>
<?php if(get_option('blog_ad6')!=""){ ?><li><?php echo get_option('blog_ad6'); ?></li><?php } ?>
              </ul>
              <a href="javascript:;" class="btn_prev"></a><a href="javascript:;" class="btn_next"></a>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
<?php get_footer(); ?>