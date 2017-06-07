<!--
Template Name: Post Page
-->
<?php get_header(); ?>

	<main role="main">
    <div class='posts'>
      <div class ='blog_posts'>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
          <?php the_content(); ?>
        <section class="page latest">
          <div class="box">
            <ul class="recently">
            <?php
              $args = array(
                'orderby' => 'date',
                'order' => 'desc',
                'post_type' => 'post',
                'posts_per_page' => 8
              );
              $recent_posts = get_posts($args);
              foreach ( $recent_posts as $recent_post ) :
                setup_postdata($recent_post);
              ?>
                <li class="post_content">
                  <ul>
                    <li>
                      <date>
                        <?php echo get_the_time('l, j F Y', $recent_post->ID); ?>
                      </date>
                    </li>
                    <li class='post_title'>
                      <a href="<?php echo get_the_permalink($recent_post->ID) ?>" class="post">
                        <?php echo $recent_post->post_title ?>
                      </a>
                    </li>
                    <li>
                      <p class="excerpt">
                        <?php echo the_excerpt() ?>
                      </p>
                    </li>
                  </ul>
                </li>
              <?php 
                  wp_reset_postdata();
                endforeach;
              ?>
            </ul>
          </div>
        </section>
      </div>

      </div>
    </div>
      
    
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
  </article>

  <?php endwhile; ?>

  <?php else: ?>


  <?php endif; ?>

  </main>

<?php get_footer(); ?>




