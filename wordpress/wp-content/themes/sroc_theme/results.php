<!--
Template Name: Results
-->
<?php get_header(); ?>
<h2 class='page_title'><?php the_title();?></h2>

	<main role="main">
		<section>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>
        <?php
          $args = array(
            'orderby' => 'date',
            'order' => 'desc',
            'post_type' => 'post',
            'posts_per_page' => 20
          );
          $recent_posts = get_posts($args);
          foreach ( $recent_posts as $recent_post ) :
            setup_postdata($recent_post);
            $cats = get_the_category($recent_post->ID);
            if ($cats[0]->name == "Results"){
              ?>
              <li class="post_content">
                <a href="<?php echo get_the_permalink($recent_post->ID) ?>" class="post">
                  <?php echo $recent_post->post_title ?>
                </a>
                <date>
                  <?php echo get_the_time('j F Y', $recent_post->ID); ?>
                </date>
              </li>              
          <?php 
              wp_reset_postdata();
            }
            endforeach;
          ?>

			</article>

		</section>
		<!-- /section -->
	</main>



<?php get_footer(); ?>