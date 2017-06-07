<?php get_header(); ?>

  <main role="main">
    <section>
      <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
              <?php the_post_thumbnail(); // Fullsize image for the single post ?>
            </a>
          <?php endif; ?>
          <a href="http://sroc.dev/">&larr; Home</a>
          <date id='post_date'>
            <?php the_time('F j, Y'); ?>
          </date>
          <h1 id='post_title'>
            <?php the_title(); ?>
          </h1>
          <?php the_content();?>
        </article>

      <?php endwhile; ?>

    <?php else: ?>

    <?php endif; ?>

  </section>

  </main>

<?php get_footer(); ?>
