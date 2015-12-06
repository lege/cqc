<?php get_header(); ?>
<div class="content-wrap">
	<div class="content">
		<header class="archive-header"> 
			<h1><a href="<?php echo get_category_link( get_cat_ID( single_cat_title('',false) ) ); ?>"><?php single_cat_title() ?></a></h1>
			<?php if ( category_description() ) echo '<div class="archive-header-info">'.category_description().'</div>'; ?>
		</header>
		<?php include( 'modules/excerpt.php' ); ?>
	</div>
</div>
<?php get_sidebar(); get_footer(); ?>