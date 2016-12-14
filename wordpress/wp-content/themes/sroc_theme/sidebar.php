<!-- sidebar -->
<aside class="sidebar" role="complementary">

	<?php get_template_part('searchform'); ?>

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
	</div>

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>
   
  <?php if ( is_active_sidebar( 'next_events' ) ) : ?>
  	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
  		<?php dynamic_sidebar( 'next_events' ); ?>
  	</div><!-- #primary-sidebar -->
  <?php endif; ?>
</aside>
<!-- /sidebar -->
