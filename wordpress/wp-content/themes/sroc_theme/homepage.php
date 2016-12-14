<!--
Template Name: Home Page
-->
<?php get_header(); ?>
  <!-- <div class='nav_placeholder'>
  </div> -->
	<main role="main">
    <div class='top'>
      <div id="events">
        <?php dynamic_sidebar( 'next_events' ); ?>
      </div>
      <div id='results'>
        <h4>Recent Results</h4>
      </div>
    </div>
    <div class='posts'>
      <div class='left'>
        <div id='twitter'>
          <a class="twitter-timeline" data-width="310" data-height="834" data-link-color="#db0000" href="https://twitter.com/SROC_1964">Tweets by SROC_1964</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
      </div>
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
                'posts_per_page' => 6
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
      <div class='right'>
        <div id="weather">
          <script type="text/javascript"> moWWidgetParams="moAllowUserLocation:true~moBackgroundColour:white~moColourScheme:white~moDays:5~moDomain:www.metoffice.gov.uk~moFSSI:320301~moListStyle:vertical~moMapDisplay:none~moShowFeelsLike:true~moShowUV:true~moShowWind:true~moSpecificHeight:380~moSpecificWidth:310~moSpeedUnits:M~moStartupLanguage:en~moTemperatureUnits:C~moTextColour:black~moGridParams:weather,temperature,pop,wind,warnings~"; </script><script type="text/javascript" src="http://www.metoffice.gov.uk/public/pws/components/yoursite/loader.js"> </script></p>
        </div>
        <div id="strava">
          <iframe height='454' width='310' frameborder='0' allowtransparency='true' scrolling='no' src='https://www.strava.com/clubs/sroc/latest-rides/261474158679483a36cda97bea22308471d52123?show_rides=true'></iframe>
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

